<?php

if (isset($_SESSION['user_id'])) {
    // redirect to vault page if logged in
    header("Location: vault.php");
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $errors = [];
    $password = $_POST['password'];

    // username character minimum limit
    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }

    // email filter for format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format invalid.";
    }

    // password character minimum limit
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // if no validation errors, proceed to database operations
    if (empty($errors)) {
        include "db_connect.php"; // establish database connection

        // checks if username or email already exist
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Username or Email already exists.";
        } else {
            // hash password for storing in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // insert new user on database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                header("Location: login.php");
                exit();
            }

            $errors[] = "Error inserting user: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
        $conn->close();
    }

    // display errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style=\"color: red;\" class='error'>$error</p>";
        }
    }
}
