<?php
require "layouts/header.php";
require "layouts/navbar.php";
?>

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

    // if no validation errors, proceed to database operations
    if (empty($errors)) {
        // database connection and insertion logic here
        include "database/db_tables.php"; // create tables if not exist
        include "database/db_connect.php"; // establish connection

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
?>
                <button type="submit" name="submit">Sign Up</button>
                <br />
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </form>

            <a class="back-home" href="index.php">Back to Homepage</a>
        </section>
    </div>
</div>

<?php
require "layouts/footer.php";
?>
