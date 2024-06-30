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

                <?php require "db/acc_login.php"; ?>

                <button type="submit">Login</button>
                <br />
                <p>Didn't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
            <a class="back-home" href="index.php">Back to Homepage</a>
        </section>
    </div>
</div>

<?php require "layouts/footer.php"; ?>
