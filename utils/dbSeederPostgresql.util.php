<?php
declare(strict_types=1);

// ✅ 1. Load all required definitions
require_once 'bootstrap.php';

// ✅ 2. Get DB credentials from .env
$host     = env('PG_HOST');
$port     = env('PG_PORT');
$username = env('PG_USER');
$password = env('PG_PASS');
$dbname   = env('PG_DB');

// ✅ 3. Connect to PostgreSQL
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// ✅ 4. Apply all model schemas
$schemas = [
    'users.model.sql',
    'projects.model.sql',
    'project_users.model.sql',
    'tasks.model.sql'
];

foreach ($schemas as $file) {
    $path = BASE_PATH . "/database/{$file}";
    echo "📄 Applying schema: {$file}…\n";
    $sql = file_get_contents($path);
    if ($sql === false) {
        throw new RuntimeException("❌ Could not read {$path}");
    }
    $pdo->exec($sql);
    echo "✅ Applied schema for: {$file}\n";
}

// ✅ 5. Truncate all tables (in dependency-safe order)
echo "🔄 Truncating tables…\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
    echo "✅ Truncated: {$table}\n";
}

// ✅ 6. Load dummy user data
$users = require DUMMIES_PATH . '/users.staticData.php';

// ✅ 7. Seed dummy data into `users`
echo "🌱 Seeding users…\n";
$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

foreach ($users as $user) {
    $stmt->execute([
        ':username' => $user['username'],
        ':role'     => $user['role'],
        ':fn'       => $user['first_name'],
        ':ln'       => $user['last_name'],
        ':pw'       => password_hash($user['password'], PASSWORD_DEFAULT),
    ]);
    echo "✅ Seeded user: {$user['username']}\n";
}

echo "🎉 Seeder + Migration complete!\n";
