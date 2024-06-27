<!DOCTYPE html>
<head>
    <title>CoNTeX | Collaborative Note-taking in Markdown and LaTeX</title>
    <link rel="icon" type="image/png" href="img/ctx-sq-light.png" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/style.css" rel="stylesheet" />
</head>

<?php
session_start();

if (isset($_COOKIE['remember_me'])) {
    $cookie_data = json_decode(base64_decode($_COOKIE['remember_me']), true);

    if ($cookie_data && isset($cookie_data['username'], $cookie_data['token'])) {
        $username = $cookie_data['username'];

        include "database/db_connect.php";

        // retrieve user data based on username
        $stmt = $conn->prepare("SELECT id, username, email, created_at FROM users WHERE username = ?");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id, $db_username, $email, $created_at);
        $stmt->fetch();

        // Automatically log the user in
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['email'] = $email;
        $_SESSION['created_at'] = $created_at;
    }
}
?>
