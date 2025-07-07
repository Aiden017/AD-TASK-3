<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';
require_once 'bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';

$host = $databases['pgHost'];
$port = $databases['pgPort'];
$username = $databases['pgUser'];
$password = $databases['pgPassword'];
$dbname = $databases['pgDB'];

$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
$pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

echo "Truncating tables…\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
  $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

$models = ['users', 'projects', 'project_users', 'tasks'];
foreach ($models as $model) {
    echo "Applying schema from database/{$model}.model.sql…\n";
    $sql = file_get_contents("database/{$model}.model.sql");
    if ($sql === false) throw new RuntimeException("❌ Could not read {$model}.model.sql");
    $pdo->exec($sql);
    echo "✅ Created {$model} table.\n";
}
