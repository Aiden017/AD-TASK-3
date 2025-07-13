<?php
declare(strict_types=1);

// 1) Autoload Composer
require_once __DIR__ . '/../vendor/autoload.php';

// 2) Load env variables (must come before bootstrap)
require_once __DIR__ . '/envSetter.util.php';

// 3) Bootstrap for dotenv (after envSetter)
require_once __DIR__ . '/../bootstrap.php';

// 4) Get DB connection values from .env
$host = env('PG_HOST');
$port = env('PG_PORT');
$dbname = env('PG_DB');
$username = env('PG_USER');
$password = env('PG_PASS');

// Debug: Print env values to verify
if (!$host || !$port || !$dbname || !$username || !$password) {
    echo "❌ One or more environment variables are missing:\n";
    echo "PG_HOST: $host\n";
    echo "PG_PORT: $port\n";
    echo "PG_DB: $dbname\n";
    echo "PG_USER: $username\n";
    echo "PG_PASS: $password\n";
    exit(1);
}

// 5) Connect to PostgreSQL
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "\n");
}

// 6) Drop old tables
echo "🧨 Dropping old tables…\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
    $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

// 7) Apply schemas
$schemas = [
    'users.model.sql',
    'projects.model.sql',
    'project_users.model.sql',
    'tasks.model.sql'
];

foreach ($schemas as $file) {
    echo "📄 Applying schema: {$file}…\n";
    $sql = file_get_contents(__DIR__ . "/../database/{$file}");

    if ($sql === false) {
        throw new RuntimeException("❌ Could not read database/{$file}");
    }

    $pdo->exec($sql);
    echo "✅ Applied schema for: " . basename($file, '.model.sql') . "\n";
}
