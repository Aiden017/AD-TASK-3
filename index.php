<?php
require_once 'bootstrap.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /pages/Login/index.php');
    exit;
}
// Include checkers after login check
require_once HANDLERS_PATH . '/postgreChecker.handler.php';
require_once HANDLERS_PATH . '/mongodbChecker.handler.php';

$postgreStatus = checkPostgreConnection();
$mongoStatus = checkMongoConnection();

$content = '<h2>Welcome, ' . htmlspecialchars($_SESSION['user']['first_name']) . '!</h2>';
$content .= '<p>' . $postgreStatus . '</p>';
$content .= '<p>' . $mongoStatus . '</p>';
include LAYOUTS_PATH . '/main.layout.php';
?>

