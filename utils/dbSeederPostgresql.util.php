<?php

declare(strict_types=1);

// Load bootstrap: defines BASE_PATH, DUMMIES_PATH, UTILS_PATH
require_once 'bootstrap.php';

// Load env helper
require_once UTILS_PATH . '/envSetter.util.php';

// Load dummy user data
$users = require DUMMIES_PATH . '/users.staticData.php';

// Connect to PostgreSQL
$host     = env('PG_HOST');
$port     = env('PG_PORT');
$dbname   = env('PG_DB');
$username = env('PG_USER');
$password = env('PG_PASS');

$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Seeding users…\n";

// Insert users
$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

foreach ($users as $u) {
    $stmt->execute([
        ':username' => $u['username'],
        ':role'     => $u['role'],
        ':fn'       => $u['first_name'],
        ':ln'       => $u['last_name'],
        ':pw'       => password_hash($u['password'], PASSWORD_DEFAULT),
    ]);
}

echo "✅ PostgreSQL seeding complete!\n";
