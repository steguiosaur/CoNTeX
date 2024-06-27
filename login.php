<?php
require "layouts/header.php";
require "layouts/navbar.php";
?>

<div class="main">
    <div class="container">
        <section class="form-section">
            <h3>Log into your Account</h3>
            <form action="" method="POST" class="form-box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />

                <p><input type="checkbox" id="remember-me" name="remember-me" /> Remember Me</p>

<?php
if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember-me']);

    include "database/db_connect.php";

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
            // Set a cookie that expires in 30 days
            $cookie_value = base64_encode(json_encode(['username' => $username, 'token' => bin2hex(random_bytes(16))]));
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
?>

                <button type="submit">Login</button>
                <br />
                <p>Didn't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
            <a class="back-home" href="index.php">Back to Homepage</a>
        </section>
    </div>
</div>

<?php
require "layouts/footer.php";
?>
