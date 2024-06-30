<?php

// check if user is logged in
if (isset($_SESSION['user_id'])) {
    // redirect to vault page if logged in
    header("Location: vault.php");
    exit();
}

if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember-me']);

    include "db_connect.php";

    // retrieve user data based on username
    $stmt = $conn->prepare("SELECT id, username, password, email, created_at FROM users WHERE username = ?");
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_username, $db_password, $email, $created_at);
    $stmt->fetch();

    // verify password and set session
    if (password_verify($password, $db_password)) {
        // verification successful
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['email'] = $email;
        $_SESSION['created_at'] = $created_at;

        if ($rememberMe) {
            // set 30 day cookie for remember me
            $cookie_value = base64_encode(json_encode(['user_id' => $user_id, 'token' => bin2hex(random_bytes(16))]));
            setcookie('remember_me', $cookie_value, time() + (30 * 24 * 60 * 60), "/");
        }

        header("Location: vault.php");
        exit();
    } else {
        echo "<p style='color: red;'>Invalid username or password.</p>";
    }

    $stmt->close();
    $conn->close();
}
