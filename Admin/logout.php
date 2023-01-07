<?php
session_start();

$authenticated = $_SESSION['user-auth'] ?? true;
if ($authenticated) {
    unset($_SESSION['user-auth']);
}

header('Location: /Admin');
