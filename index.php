<?php
include 'layouts/header.php';
include 'layouts/navbar.php';
?>

<button id="scroll-top-btn" title="Go to top">^</button>

<div class="main">
    <div class="container">
        <section class="main-intro">
            <div class="main-intro-row">
                <div class="main-intro-col">
                    <div class="text-content">
                        <h1>Write Mathematical<br />Expressions with Ease</h1>
                        <p>
                            Collaborate expression heavy documents without lifting<br />
                            away from the keyboard.
                        </p>
<?php
// hide login and signup when session == true
if (!isset($_SESSION['username'])) {
    echo "<a href=\"signup.php\"><button class=\"btn-fill\" type=\"button\">Sign Up</button></a>";
    echo "<a href=\"login.php\"><button class=\"btn-outline\" type=\"button\">Login</button></a>";
}
?>
                    </div>
                    <img width="300px" height="auto" src="img/branchnbound.svg" alt="" />
                </div>
                <div class="read-more">
                    <a href="#read-more-section">Read More</a>
                </div>
            </div>
        </section>
        <section class="main-content" id="read-more-section">
            <br />

            <div class="feature-section">
                <h3>Texts? Diagrams? Equations? We can handle them all!</h3>
            </div>

            <div class="feature-section">
                <div class="feature-content">
                    <h6>Edit with Markdown, LaTeX, and UML</h6>
                    <p>All in one editor for Markdown, LaTeX, and UML.</p>
                </div>
                <div class="feature-image">
                    <!-- Placeholder for image -->
                    <div class="image-placeholder"></div>
                </div>
            </div>

            <div class="feature-section">
                <div class="feature-content">
                    <h6>Extended LaTeX compilation</h6>
                    <p>
                        Not limiting towards compileable LaTeX code compared to
                        StackEdit, Obsidian, etc. that are reliant on MathJax
                    </p>
                </div>
                <div class="feature-image">
                    <!-- Placeholder for image -->
                    <div class="image-placeholder"></div>
                </div>
            </div>

            <div class="feature-section">
                <div class="feature-content">
                    <h6>Live rendering</h6>
                    <p>
                        No manual compilation needed, write your stuff and see the
                        changes in real time.
                    </p>
                </div>
                <div class="feature-image">
                    <!-- Placeholder for image -->
                    <div class="image-placeholder"></div>
                </div>
            </div>

            <div class="feature-section">
                <div class="feature-content">
                    <h6>Collaboration made easy</h6>
                    <p>Collaborate and share progress with teams</p>
                </div>
                <div class="feature-image">
                    <!-- Placeholder for image -->
                    <div class="image-placeholder"></div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="js/homescroll.js"></script>

<?php
include 'layouts/footer.php';
?>
