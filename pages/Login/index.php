<?php
require_once '../../bootstrap.php';
session_start();

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);

include COMPONENTS_PATH . '/loginForm.component.php';

if ($error) {
    echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
}
