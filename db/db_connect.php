<?php

// Change values if necessary
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "contex";

// Create connection to database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
