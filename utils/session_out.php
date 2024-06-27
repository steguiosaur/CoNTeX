<?php

session_start();

// destroy the session
session_unset(); // unset all session variables
session_destroy();

// unset the remember_me cookie
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

header("Location: ../index.php");
exit();
