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
                <h3>Log into your Account</h3>
                <form action="/login" method="post" class="form-box">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required />

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />

                    <a href="login.php">Forgot Password?</a>

                    <button type="submit">Login</button>
                    <br />
                    <p>Didn't have an account? <a href="signup.php">Sign Up</a></p>
                </form>
                <a class="back-home" href="index.php">Back to Homepage</a>
            </section>
        </div>
    </div>

    <footer>
        <div class="container">Copyright 2024 Steve Pabular</div>
    </footer>
</body>

</html>