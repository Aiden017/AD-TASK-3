<?php
require_once '../../utils/envSetter.util.php';     // ✅ Manually resolved
require_once '../../bootstrap.php';                // ✅ Manually resolved
require_once '../../utils/auth.util.php';          // ✅ Manually resolved

session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = env('PG_HOST');
    $port = env('PG_PORT');
    $dbname = env('PG_DB');
    $username = env('PG_USER');
    $password = env('PG_PASS');

    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $user = verifyLogin($_POST['username'], $_POST['password'], $pdo);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: /index.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}

include '../../components/loginForm.component.php'; // ✅ Manually resolved

if ($error) {
    echo '<p style="color:red">' . htmlspecialchars($error) . '</p>';
}
