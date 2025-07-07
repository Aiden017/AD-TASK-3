<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';
require_once 'bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';

$dsn = "pgsql:host={$databases['pgHost']};port={$databases['pgPort']};dbname={$databases['pgDB']}";
$pdo = new PDO($dsn, $databases['pgUser'], $databases['pgPassword'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Dropping old tables…\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
    $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

foreach (['users', 'projects', 'project_users', 'tasks'] as $model) {
    echo "Applying schema from database/{$model}.model.sql…\n";
    $sql = file_get_contents("database/{$model}.model.sql");
    if ($sql === false) throw new RuntimeException("❌ Could not read {$model}.model.sql");
    $pdo->exec($sql);
    echo "✅ Created {$model} table.\n";
}
