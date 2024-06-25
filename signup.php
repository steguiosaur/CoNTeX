<!doctype html>
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
                <h3>Create an Account</h3>
                <form action="" method="POST" class="form-box">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required />

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required />

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />

                    <?php
                    if (isset($_POST['submit'])) {
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $errors = [];

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

                        // error checker
                        if (empty($errors)) {
                            // hash password for storing in the database
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                            // database connection and insertion logic here
                            include("database/db_tables.php"); // create tables if not exist
                            include("database/db_connect.php"); // establish connection

                            // SQL statement preparation
                            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                            if ($stmt === false) {
                                die("Prepare failed: " . htmlspecialchars($conn->error));
                            }

                            // execute the statement
                            $stmt->bind_param("sss", $username, $email, $hashed_password);
                            if ($stmt->execute()) {
                                header("Location: login.php");
                                exit();
                            }

                            $stmt->close();
                        } else {
                            // show all errors collected
                            foreach ($errors as $error) {
                                echo "<p style=\"color: red;\" class='error'>$error</p>";
                            }
                        }
                    }
                    ?>

                    <button type="submit" name="submit">Sign Up</button>
                    <br />
                    <p>Already have an account? <a href="login.php">Sign In</a></p>
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
