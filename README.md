# Capitalyze Web

Capitalyze Web is a Laravel 9 application that utilizes Livewire, Jetstream, and Sushi for a seamless user experience.

## Table of Contents

- [Requirements](#requirements)
- [Getting Started](#getting-started)
- [Running the Project Locally](#running-the-project-locally)
- [Debugging](#debugging)
- [Deployment](#deployment)

## Requirements

Before you proceed, make sure you have the following software installed on your system:

- PHP >= 8.0.2
- Composer
- Node.js >= v18 (you can install nvm for better compatibility)
- Yarn
- Docker (For local development)
- Laravel Vapor CLI (For production deployment)

## Getting Started

#### 1. Clone the repository:

```sh
git clone git@github.com:Capitalyze-Inc/capitalyze-web.git
cd xbrl-explorer-laravel
```

#### 2. Install PHP dependencies:

```sh
composer install
```
When you'll be installing the project for the first time you'll be prompted for a licence for wire-elements-pro. Either use your own licence or this one :
```sh
axxd.xxx@hxxhi.fr
1xx4d-4xx7-4xxf-bxx1-7a6xxxxxd13e
```

#### 3. Install Node.js dependencies:
If you have nvm installed :
```sh
nvm use
```
then :
```sh
yarn install
```
or : 
```sh
npm i
```

#### 4. Copy the `.env.example` file to create a `.env` file.

```sh
cp .env.example .env
```

#### 5. Generate an app encryption key:

```sh
php artisan key:generate
```

#### 6. Start the Docker containers for the database (locally):

```sh
docker-compose up -d
```

#### 7. Run the database migrations:

```sh
php artisan migrate
```

#### 8. Import data to local database:

```sh
php artisan capitalyze:import
```

#### 9. Create your first admin user:

```sh
php artisan create:admin Username email@example.com 'password'
```

## Running the Project Locally

#### 1. Start the Laravel development server:

```sh
php artisan serve
```

#### 2. Visit `http://localhost:8000` in your browser.

#### 3. On a different tab of your command line, run the live css compilator:

```sh
npm run dev
```

#### 3. Handling e-mails

In order to test e-mails locally, you need to install mailhog

on mac :

```sh
brew install mailhog
```

## Debugging

- You can use Xdebug for debugging PHP. Follow the [official documentation](https://xdebug.org/docs/install) for installation and setup.

To debug SQL queries we use papertrail as you can see in logging.php

```php
'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SocketHandler::class,
            'handler_with' => [
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
        ],
```
and inside AppServiceProvider.php

```php
    public function boot()
    {
        if (App::environment('production')) {
            DB::listen(function($query) {
                Log::stack(['papertrail'])->debug(
                    "Query: {$query->sql}, Bindings: ".json_encode($query->bindings).", Time: {$query->time}"
                );
            });
        }
        // log DB request local to termninal for debugging purposes
        if (App::environment('local')) {
            DB::listen(function($query) {
                Log::debug(
                    "Query: {$query->sql}, Bindings: ".json_encode($query->bindings).", Time: {$query->time}"
                );
            });
        }
    }
```
to access the papertrail interface, you need to be invited, so please ask for an account.

## Deployment

#### 1. Install the Vapor CLI if you haven't already:

```sh
composer global require laravel/vapor-cli
```

#### 2. Log in to your Vapor account:

```sh
vapor login
```

#### 3. Deploy the project:

```sh
vapor deploy [environment]
```

> Note: Replace `[environment]` with the environment name you are deploying to, as configured in your `vapor.yml` file (e.g. `production` or `staging`).

## Contributing

Guidelines for contributing to this project.

## License

This project is copyrighted.

## Schema


