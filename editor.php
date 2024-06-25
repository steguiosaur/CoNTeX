<!doctype html>
<html lang="en">

<head>
    <title>CoNTeX</title>
    <link rel="icon" type="image/png" href="img/ctx-sq-light.png" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/preview.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="navbar-tools">
                <button id="folder-button" class="nb-btn" type="button">
                    <img id="folder-icon" class="nb-tl-svg" src="img/folder-solid.svg" alt="folder" />
                </button>
                <button class="nb-btn" type="button">
                    <img class="nb-tl-svg" src="img/rotate-left-solid.svg" alt="undo" />
                </button>
                <button class="nb-btn" type="button">
                    <img class="nb-tl-svg" src="img/rotate-right-solid.svg" alt="redo" />
                </button>

                <p>document.md</p>
            </div>

            <a href="index.php" id="logo-name">
                <img id="logo-img" src="img/ctx-light.png" alt="CoNTeX logo" /></a>
        </div>
    </nav>

    <!-- Editor and previewer for LaTeX and Markdown -->
    <div class="editor">
        <div class="half-width">
        <?php
        // Query database to get the first file it encounters from vault.
        // If none, create an introductory README file.
        $vault = "vault";
        $file = "./README.md";

        if (file_exists($file)) {
            $file_contents = file_get_contents($file);
        }
        ?>

        <!-- Load contents of the file to be edited -->
        <textarea class="inside-half-width" id="source-text" placeholder="Enter your text here"><?php
          echo htmlspecialchars($file_contents);
        ?></textarea>
        </div>

        <pre class="half-width"><code
        class="inside-half-width" 
        id="render-text">Text</code></pre>
    </div>
</body>

<script src="js/parser.js"></script>
<script src="js/editor.js"></script>

</html>
