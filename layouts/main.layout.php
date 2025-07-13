<?php
// Basic layout wrapper
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AD-Task-3</title>
    <link rel="stylesheet" href="/assets/css/user.css">
</head>
<body>
    <header><h1>AD-Task-3</h1></header>
    <main>
        <?php if (isset($content)) echo $content; ?>
    </main>
    <footer><a href="/pages/Logout/index.php">Logout</a></footer>
</body>
</html>
