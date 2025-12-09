<?php
// login.php
require_once 'config.php';

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (fazerLogin($username, $password)) {
        header('Location: dashboard.php');
        exit;
    } else {
        header('Location: index.php?login=true&erro=1');
        exit;
    }
}

// Se não for POST, redireciona para index
header('Location: index.php');
exit;
?>