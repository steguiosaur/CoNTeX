<?php

// change values if necessary
$servername = "localhost"; // or database server name
$dbusername = "root"; // database username (recommend not to use root)
$dbpassword = ""; // database password
$dbname = "contex"; // database name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
