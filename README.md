
# Coalition Laravel Coding Test

## About The Project

This project is a Laravel-based application developed as part of the Coalition Laravel Coding Test. It demonstrates the use of various Laravel features and packages, including a Docker-powered local development environment, user-friendly command-line forms, and a powerful REPL for the Laravel framework.

## Features

- Project and Task management
- Docker integration with Laravel Sail
- User-friendly command-line interface with Laravel Prompts
- Interactive REPL with Laravel Tinker

## Requirements

- PHP 7.4+
- Composer
- Docker (for Sail package)

## Installation

1. Clone the repository:

```bash
git clone https://github.com/Alexanderndi/coalitionLaravelCodingTest.git
```


2. Navigate to the project directory:

```bash
cd coalitionLaravelCodingTest
```

3. Install the dependencies:

```bash
composer install
```

4. Start the Docker containers:

```bash
./vendor/bin/sail up
```

OR

```bash
docker-compose up
```

5. Migrate the database:

```bash
./vendor/bin/sail artisan migrate
```
OR
 ```bash
sail artisan migrate
```

### Accessing the Application

Open your web browser and visit `http://localhost` (for Sail) or `http://localhost:8000` (for `artisan serve`).

### Running Tests

```bash
./vendor/bin/sail artisan test
```
OR
```bash
php artisan test
```

## Project Structure

- `app/`: Contains the core application logic
  - `Http/Controllers/`: Application controllers
  - `Models/`: Eloquent models
- `database/`: Database migrations and factories
- `resources/`: Views, CSS, and JavaScript files
- `routes/`: Application routes
- `tests/`: Application tests

## Key Components

### Sail

Laravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker development environment. Sail provides a great starting point for building a Laravel application using PHP, MySQL, and Redis without requiring prior Docker experience.

### Prompts

Laravel Prompts is a package that allows you to add beautiful and user-friendly forms to your command-line applications. It's perfect for accepting user input in your Artisan console commands.

### Serializable Closure

This package enables you to serialize closures in PHP, providing an easy and secure way to handle closures.

### Tinker

Tinker is a powerful REPL for the Laravel framework, allowing you to interactively explore and manipulate your application's data and logic.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail via the contact information provided in the `composer.json` file. All security vulnerabilities will be promptly addressed.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgements

- [Laravel](https://laravel.com)
- [Laravel Sail](https://laravel.com/docs/sail)
- [Laravel Prompts](https://laravel.com/docs/10.x/prompts)
- [Laravel Tinker](https://github.com/laravel/tinker)
