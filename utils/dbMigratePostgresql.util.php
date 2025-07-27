<?php

declare(strict_types=1);

// 1) Bootstrap: defines BASE_PATH, UTILS_PATH, etc.
require_once 'bootstrap.php';

// 2) Load env() helper
require_once UTILS_PATH . '/envSetter.util.php';

// 3) Get DB connection values from .env
$host     = env('PG_HOST');
$port     = env('PG_PORT');
$dbname   = env('PG_DB');
$username = env('PG_USER');
$password = env('PG_PASS');

// 4) Check .env values
if (!$host || !$port || !$dbname || !$username || !$password) {
    echo "❌ One or more environment variables are missing:\n";
    echo "PG_HOST: $host\n";
    echo "PG_PORT: $port\n";
    echo "PG_DB: $dbname\n";
    echo "PG_USER: $username\n";
    echo "PG_PASS: $password\n";
    exit(1);
}

// 5) Create PDO connection
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "\n");
}

// 6) Drop existing tables (order matters due to FK constraints)
echo "🧨 Dropping existing tables...\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
    $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
    echo "❌ Dropped: {$table}\n";
}

// 7) Apply schema files
echo "📥 Applying table schemas...\n";
$schemas = [
    'users.model.sql',
    'projects.model.sql',
    'project_users.model.sql',
    'tasks.model.sql'
];

foreach ($schemas as $filename) {
    $filepath = BASE_PATH . "/database/{$filename}";
    echo "📄 Processing: {$filename}...\n";

    $sql = file_get_contents($filepath);
    if ($sql === false) {
        throw new RuntimeException("❌ Failed to read schema file: {$filepath}");
    }

    $pdo->exec($sql);
    echo "✅ Created table: " . basename($filename, '.model.sql') . "\n";
}

echo "🎉 Migration complete!\n";
