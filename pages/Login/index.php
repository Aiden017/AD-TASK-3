<?php
$envPath = dirname(__DIR__, 2) . '/utils/envSetter.util.php';
if (!file_exists($envPath)) {
    die('envSetter.util.php not found at: ' . $envPath);
}
require_once $envPath;
require_once dirname(__DIR__, 2) . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = env('PG_HOST');
    $port = env('PG_PORT');
    $dbname = env('PG_DB');
    $username = env('PG_USER');
    $password = env('PG_PASS');
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $user = verifyLogin($_POST['username'], $_POST['password'], $pdo);
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: /index.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
include COMPONENTS_PATH . '/loginForm.component.php';
if ($error) echo '<p style="color:red">' . htmlspecialchars($error) . '</p>';
