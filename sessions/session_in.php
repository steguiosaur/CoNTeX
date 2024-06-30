<?php

if (isset($_COOKIE['remember_me'])) {
    $cookie_data = json_decode(base64_decode($_COOKIE['remember_me']), true);

    if ($cookie_data && isset($cookie_data['user_id'], $cookie_data['token'])) {
        $user_id = $cookie_data['user_id'];

        include "db/db_connect.php";

        // retrieve user data based on user_id
        $stmt = $conn->prepare("SELECT id, username, email, created_at FROM users WHERE id = ?");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($db_user_id, $username, $email, $created_at);
        $stmt->fetch();

        // Automatically log the user in
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['created_at'] = $created_at;

        $stmt->close();
    }
}
