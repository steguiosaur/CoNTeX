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
            <a href="/" id="logo-name">
                <img id="logo-img" src="img/ctx-light.png" alt="CoNTeX logo" />CoNTeX</a>
        </div>
    </nav>

    <div class="main">
        <div class="container">
            <section class="form-section">
                <h3>Create an Account</h3>
                <form action="/login" method="post" class="form-box">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required />

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required />

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />

                    <button type="submit">Sign Up</button>
                    <br />
                    <p>Already have an account? <a href="login.php">Sign In</a></p>
                </form>
                <a class="back-home" href="/">Back to Homepage</a>
            </section>
        </div>
    </div>

    <footer>
        <div class="container">Copyright 2024 Steve Pabular</div>
    </footer>
</body>

</html>
