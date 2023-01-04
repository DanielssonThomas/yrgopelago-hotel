<?php
session_start();
$authenticated = $_SESSION['user-auth'] ?? true;
if ($authenticated) {
    unset($_SESSION['user-auth']);
    echo "You have logged out";
}

header('Location: /Admin');
