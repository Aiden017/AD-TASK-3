<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';
require_once 'bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';

$users = require_once DUMMIES_PATH . '/users.staticData.php';

$dsn = "pgsql:host={$databases['pgHost']};port={$databases['pgPort']};dbname={$databases['pgDB']}";
$pdo = new PDO($dsn, $databases['pgUser'], $databases['pgPassword'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Seeding users…\n";
$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");
foreach ($users as $u) {
    $stmt->execute([
        ':username' => $u['username'],
        ':role' => $u['role'],
        ':fn' => $u['first_name'],
        ':ln' => $u['last_name'],
        ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
    ]);
}
echo "✅ PostgreSQL seeding complete!\n";
