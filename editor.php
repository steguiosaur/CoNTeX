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
        <!-- Get default mesage on screen -->
        <?php
        $file_path = "./README.md";

        if (file_exists($file_path)) {
            $file_contents = file_get_contents($file_path);
        }
        ?>

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
