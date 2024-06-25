<!DOCTYPE html>
<html lang="en">

<head>
    <title>CoNTeX</title>
    <link rel="icon" type="image/png" href="img/ctx-sq-light.png" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <div class="container navbar">
            <a href="index.php" id="logo-name">
                <img id="logo-img" src="img/ctx-light.png" alt="CoNTeX logo" />CoNTeX</a>
        </div>
    </nav>

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
                    session_start();

                    if (isset($_POST['username'], $_POST['password'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];

                        include("database/db_connect.php");

                        // retrieve user data based on username
                        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
                        if ($stmt === false) {
                            die("Prepare failed: " . htmlspecialchars($conn->error));
                        }
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $stmt->bind_result($user_id, $db_username, $db_password);
                        $stmt->fetch();

                        // verify password and set session
                        if (password_verify($password, $db_password)) {
                            // verification successful
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['username'] = $db_username;

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

    <footer>
        <div class="container">&copy CoNTeX 2024. All Rights Reserved.</div>
    </footer>
</body>

</html>
