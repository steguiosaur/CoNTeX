<!-- markdownlint-disable -->
<h1 align="center">CoNTeX</h1>

<div align="center">
  <img width="300" height="auto" src="./public/images/ctx-light.png" alt="Logo">
</div>

</br>

<p align="center">
    An Interactive Web-Based Note-Taking Platform with Markdown, LaTeX, and UML Support
</p>

<div align="center">
    <img src=".github/images/Screenshot 2025-02-11 at 09-41-00 CoNTeX Home.png" alt="CoNTeX Home">
    <img src=".github/images/Screenshot 2025-02-11 at 11-04-34 CoNTeX Editor.png" alt="CoNTeX Editor">
</div>

<details>
    <summary>View Other Screenshots</summary>
    <img src=".github/images/Screenshot 2025-02-11 at 09-41-12 CoNTeX Home.png" alt="CoNTeX Home 2">
    <img src=".github/images/Screenshot 2025-02-11 at 09-41-34 CoNTeX Login.png" alt="CoNTeX Login">
    <img src=".github/images/Screenshot 2025-02-11 at 09-41-43 CoNTeX Register.png" alt="CoNTeX Register">
    <img src=".github/images/Screenshot 2025-02-11 at 09-45-07 CoNTeX Vaults.png" alt="CoNTeX Vaults">
</details>

<!-- markdownlint-enable -->

## Requirements

- Php 8.3
- Composer
- Node.js
- PostgreSQL
- Docker (when using Laravel Sail)

## Development Setup

1. Clone repository:

    ```sh
    git clone https://github.com/steguiosaur/CoNTeX.git
    cd ./CoNTeX/
    ```

2. Install dependencies:

    ```sh
    npm install
    composer install
    ```

3. Copy `.env.example` contents to a new `.env` file:

    ```sh
    cp ./.env.example ./.env
    ```

4. Edit database information on `.env` or leave defaults:

    ```txt
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=contex
    DB_USERNAME=root
    DB_PASSWORD=<input_password>
    ```

5. Generate and load keys:

    > Use `./vendor/bin/sail` instead of `php` when using Laravel Sail

    ```sh
    php artisan key:generate
    php artisan config:clear
    ```

6. Start `postgresql` service

7. Run database migrations:

    > Use `./vendor/bin/sail` instead of `php` using Laravel Sail

    ```sh
    php artisan migrate
    ```

8. Build and run project:

    ```sh
    npm run build
    php artisan serve
    ```

    > using Laravel Sail

    ```sh
    sudo systemctl start docker.service
    ./vendor/bin/sail up
    ```

9. Access site on [localhost:8000](localhost:8000)

10. **[DEV]** Start development server (on separate terminal)

    ```sh
    npm run dev
    ```
