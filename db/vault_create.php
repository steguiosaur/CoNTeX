<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_vault'])) {
    include 'db/db_connect.php'

    // Sanitize and validate input
    $vault_name = $_POST['vault_name']; // assuming this comes from your form input
    // You should sanitize and validate $vault_name input here to prevent SQL injection

    // Insert new vault into database
    $insert_sql = "INSERT INTO vaults (user_id, name) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("is", $user_id, $vault_name);

    if ($stmt->execute()) {
        // Vault created successfully, redirect or do further processing
        // Optionally, you can set a success message or handle the response
        // Example: header('Location: your_vault_page.php');
    } else {
        // Error handling if insertion fails
        echo "Error: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
