# CoNTeX

Collaborative note-taking web app with Markdown and $\LaTeX$ syntax

## Required

Use PHP as the primary programming language

- PHP
- Apache (Web Server)
- MariaDB/MySQL (RDBMS)

## Overall Planned Features

1. Login/SignUp user account system
2. Markdown + $\LaTeX$ editor
3. Markdown + $\LaTeX$ previewer
4. File-tree for Current Notes in the Vault
5. Notes vault sharing for collaborative editing

### v0.2.0 Features

- [ ] Syntax highlighting on editor
- [ ] Auto-pairing for brackets, parenthesis, and other delimiters

### v0.1.0 Features

- [x] `<textarea>` field for editing
- [x] `<previewer>` field for rendering parsed Markdown text
- [x] `<previewer>` update on `<textarea>` input
- [x] Scroll synchronization on `<textarea>` and `<previewer>`
- [x] Markdown parser
- [x] $\LaTeX$ parser

## Sample LaTeX + Markdown

The **Naive Bayes** is a well-known probabilistic-supervised machine learning algorithm that utilizes Bayes' theorem to make predictions. It was called "naive" since it assumes that features in the dataset are independent of each other, which is often not the case in real-world data. Even with these assumptions, this algorithm can still work on producing accurate predictions on many cases. This algorithm is usually involved on text classification, spam filtering, and sentiment analysis among multiple use cases.

A thing to discuss here first is the root of its concept, the **Bayes theorem**, which provides a way of computing posterior probability $P(h|d)$ from $P(h)$, $P(d)$ and $P(d|h)$, where $h$ is the hypothesis or belief we hold and $d$ as some body of data. Together, we could assume that this is the probability of a hypothesis being true given some data. It could also provide a way to update how strongly the belief is held as new data becomes available.

$$
\begin{equation}
    P(h|d) = \frac{P(d|h) \cdot P(h)}{P(d)}
\end{equation}
$$

In plain English version in same layout.

$$
\begin{equation}
    \text{posterior} = \frac{\text{prior} \cdot
\text{likelihood}}{\text{evidence}} \end{equation}
$$

Table in Markdown:

| Header 1 | Header 2 |
| -------- | -------- |
| Cell 1   | Cell 2   |
| Cell 3   | Cell 4   |

Sample matrices:

$$
T^{\mu\nu}=\begin{pmatrix}
\varepsilon&0&0&0\\
0&\varepsilon/3&0&0\\
0&0&\varepsilon/3&0\\
0&0&0&\varepsilon/3
\end{pmatrix},
$$

Sample integrals:

$$P_\omega={n_\omega\over 2}\hbar\omega\,{1+R\over 1-v^2}\int\limits_{-1}^{1}dx\,(x-v)|x-v|,$$
