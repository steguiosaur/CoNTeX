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

                <?php require "db/acc_signup.php"; ?>

                <button type="submit" name="submit">Sign Up</button>
                <br />
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </form>

            <a class="back-home" href="index.php">Back to Homepage</a>
        </section>
    </div>
</div>

<?php require "layouts/footer.php"; ?>
