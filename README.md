<h1 align="center">CoNTeX</h1>

<div align="center">
  <img width="300" height="auto" src="./public/images/ctx-light.png" alt="Logo">
</div>

</br>

<p align="center">
    An Interactive Web-Based Note-Taking Platform with Markdown, LaTeX, and UML Support
</p>

## Requirements

- Php 8.3
- Composer
- Node.js
- MySQL/MariaDB Database

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
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=contex
    DB_USERNAME=root
    DB_PASSWORD=<input_password>
    ```

5. Generate and load keys:

    ```sh
    php artisan key:generate
    php artisan config:clear
    ```

6. Start MySQL service

7. Run database migrations:

    ```sh
    php artisan migrate
    ```

8. Build and run project:

    ```sh
    npm run build
    php artisan serve
    ```

9. Access site on [localhost:8000](localhost:8000)

10. **[DEV]** Start development server (on separate terminal)

    ```sh
    npm run dev
    ```
