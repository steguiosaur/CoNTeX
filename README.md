![CoNTeX Logo](img/ctx-light.png#gh-dark-mode-only)
![CoNTeX Logo](img/ctx-dark.png#gh-light-mode-only)

## Description

Collaborative note-taking web app with Markdown and $\LaTeX$ syntax

## Screenshots

<details>
  <summary>Screenshots</summary>
    <img src="./img/Screenshot CoNTeX Editor.png" alt="Editor Page">
    <img src="./img/Screenshot CoNTeX Home.png" alt="Home Page">
    <img src="./img/Screenshot CoNTeX SignUp.png" alt="SignUp Page">
    <img src="./img/Screenshot CoNTeX Login.png" alt="Login Page">
</details>

## Installation and Setup

Assuming the project would be ran using [XAMPP](https://www.apachefriends.org/):

1. Clone the repository `git clone https://github.com/steguiosaur/CoNTeX.git` to
   `htdocs`:

   **Windows**:

   ```sh
   cd C:\Xampp\htdocs
   git clone https://github.com/steguiosaur/CoNTeX.git
   ```

   **Linux**: Copy the directory to `/opt/lampp/htdocs`

   ```sh
   git clone https://github.com/steguiosaur/CoNTeX.git
   sudo cp -r CoNTeX/ /opt/lampp/htdocs
   ```

   > **DEV**: Create symlink to some `<project_dir>` for CoNTeX

   ```sh
   cd /opt/lampp/htdocs
   sudo chown -R $USER:$USER CoNTeX/
   sudo ln -s CoNTeX/ <project_dir>
   ```

2. Start the project on a local server (e.g., XAMPP, LAMPP).

   **Windows**: Use XAMPP control panel

   **Linux**: For GUI, execute `sudo xampp-manager`; For CLI:

   ```sh
   sudo /opt/lampp/lampp start
   ```

3. Visit import page of [http://localhost/phpmyadmin](http://localhost/phpmyadmin/index.php?route=/server/import)
   and import the file `db/setup_database.sql` to setup the database.

4. Access the webpage on [http://localhost/CoNTeX/index.php](http://localhost/CoNTeX/index.php)

## Overall Planned Features

1. Login/SignUp user account system
2. Markdown + $\LaTeX$ editor
3. Markdown + $\LaTeX$ previewer
4. File-tree for Current Notes in the Vault
5. Notes vault sharing for collaborative editing

### v0.2.0 Features

- [x] Responsive design for mobile users
- [x] Account system
- [x] Developed profile page
- [x] Vault creation for storing related files
- [x] Remember sessions for each user
- [x] Auto-pairing for brackets, parenthesis, and other delimiters

### v0.1.0 Features

- [x] `<textarea>` field for editing
- [x] `<previewer>` field for rendering parsed Markdown text
- [x] `<previewer>` update on `<textarea>` input
- [x] Scroll synchronization on `<textarea>` and `<previewer>`
- [x] Markdown parser
- [x] $\LaTeX$ parser

### Future Development

- [ ] UML Diagram
- [ ] Syntax highlighting on editor
- [ ] Vault sharing for collaborative editing
- [ ] File-tree for Current Notes in the Vault
- [ ] Notes vault sharing for collaborative editing

## User Guide

The editor uses standard Markdown syntax, with the combination of $\LaTeX$
accessible through the dollar symbol.

> UML would be implemented in the later versions.

| Syntax               | Description                        |
| -------------------- | ---------------------------------- |
| `#`                  | Heading level 1                    |
| `##`                 | Heading level 2                    |
| `###`                | Heading level 3                    |
| `####`               | Heading level 4                    |
| `#####`              | Heading level 5                    |
| `######`             | Heading level 6                    |
| `*italic*`           | Italic text using asterisks        |
| `_italic_`           | Italic text using underscores      |
| `**bold**`           | Bold text using double asterisks   |
| `__bold__`           | Bold text using double underscores |
| `~~strikethrough~~`  | Strikethrough text                 |
| `*`                  | Unordered list item using asterisk |
| `-`                  | Unordered list item using hyphen   |
| `+`                  | Unordered list item using plus     |
| `1.`                 | Ordered list item                  |
| `[link](url)`        | Hyperlink                          |
| `![alt text](url)`   | Image                              |
| `> quote`            | Blockquote                         |
| `` ` code ` ``       | Inline code                        |
| ` ``` code ``` `     | Code block with backticks          |
| `---`                | Horizontal rule using dashes       |
| `___`                | Horizontal rule using underscores  |
| `***`                | Horizontal rule using asterisks    |
| `![Alt text](URL)`   | Image                              |
| `[^1]`               | Footnote                           |
| `==highlight==`      | Highlight                          |
| `$inline equation$`  | Inline LaTeX equation              |
| `$$block equation$$` | Block LaTeX equation               |
| `::: uml :::`        | UML diagrams                       |

### Sample text with inline math

A thing to discuss here first is the root of its concept, the **Bayes theorem**,
which provides a way of computing posterior probability $P(h|d)$ from $P(h)$,
$P(d)$ and $P(d|h)$, where $h$ is the hypothesis or belief we hold and $d$ as
some body of data. Together, we could assume that this is the probability of a
hypothesis being true given some data. It could also provide a way to update how
strongly the belief is held as new data becomes available.

### Sample equation

$$
\begin{equation}
    P(h|d) = \frac{P(d|h) \cdot P(h)}{P(d)}
\end{equation}
$$

### Sample table in Markdown

| Header 1 | Header 2 |
| -------- | -------- |
| Cell 1   | Cell 2   |
| Cell 3   | Cell 4   |

### Sample matrices

$$
T^{\mu\nu}=\begin{pmatrix}
\varepsilon&0&0&0\\
0&\varepsilon/3&0&0\\
0&0&\varepsilon/3&0\\
0&0&0&\varepsilon/3
\end{pmatrix},
$$

### Sample integrals

$$P_\omega={n_\omega\over 2}\hbar\omega\,{1+R\over 1-v^2}\int\limits_{-1}^{1}dx\,(x-v)|x-v|,$$

### Beyond MathJax renders

We could do more complex $LaTeX$ compiled renders vs MathJax. All thanks to
**Parpalak**, the creator of [upmath.me](https://upmath.me/)

> This would error when displayed on Github
