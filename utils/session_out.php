<?php

session_start();

// destroy the session
session_unset(); // unset all session variables
session_destroy();

header("Location: ../index.php");
exit();
