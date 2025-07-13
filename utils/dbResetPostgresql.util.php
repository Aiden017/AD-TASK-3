<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/envSetter.util.php';

$host = env('PG_HOST');
$port = env('PG_PORT');
$dbname = env('PG_DB');
$username = env('PG_USER');
$password = env('PG_PASS');

$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "\n");
}

// ✅ 1. Apply table schemas first
$models = ['users', 'projects', 'project_users', 'tasks'];
foreach ($models as $model) {
    $path = __DIR__ . "/../database/{$model}.model.sql";
    echo "📄 Applying schema: {$model}.model.sql…\n";
    $sql = file_get_contents($path);
    if ($sql === false) {
        throw new RuntimeException("❌ Could not read {$path}");
    }
    $pdo->exec($sql);
    echo "✅ Applied schema for: {$model}\n";
}

// ✅ 2. Truncate tables AFTER they are created
echo "🔄 Truncating tables…\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
    echo "✅ Truncated: {$table}\n";
}
