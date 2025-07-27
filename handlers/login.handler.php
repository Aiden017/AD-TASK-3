<?php
// handlers/login.handler.php
require_once '../bootstrap.php';

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $host     = env('PG_HOST');
        $port     = env('PG_PORT');
        $dbname   = env('PG_DB');
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
            $_SESSION['login_error'] = 'Invalid credentials';
            header('Location: /pages/Login/index.php');
            exit;
        }

    } catch (Exception $e) {
        $_SESSION['login_error'] = 'Something went wrong.';
        header('Location: /pages/Login/index.php');
        exit;
    }
}
