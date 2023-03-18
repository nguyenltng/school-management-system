## CloudSchool

[![Codeship Status for hrshadhin/school-management-system](https://app.codeship.com/projects/09010350-b97f-0136-1477-5a7589b245e6/status?branch=master)](https://app.codeship.com/projects/312233)
[![php](https://img.shields.io/badge/php-7.2-brightgreen.svg?logo=php)](https://www.php.net)
[![laravel](https://img.shields.io/badge/laravel-6.x-orange.svg?logo=laravel)](https://laravel.com)

#### Installing dependencies

- PHP >= 7.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- MySQL >= 5.6 `OR` MariaDB >= 10.1
- [hrshadhin/laravel-userstamps](https://github.com/hrshadhin/laravel-userstamps.git) [**Already Installed**]
- NodeJS, npm, webpack

#### Download and setup

- Clone the repo

  **For Windows run below commands before cloning the Repo.**

- Install php libraries
  ```
  $ composer install
  ```
- Setup application
 - Setup application 
- Setup application
 - Setup application 
- Setup application

  - Method 1: By one command

    ```
    # setup cloudschool with out demo data
    $ php artisan fresh-install

    # setup cloudschool with demo data
    $ php artisan fresh-install --with-data
     # OR
    $ php artisan fresh-install -d
    ```

  - Method 2: Step by step

    ```
    $ php artisan storage:link
    $ php artisan key:generate --ansi

    # Create database tables and load essential data
    $ php artisan migrate
    $ php artisan db:seed

    # Load demo data
    $ php artisan db:seed --class DemoSiteDataSeeder
    $ php artisan db:seed --class DemoAppDataSeeder

    # Clear all caches
    $ php artisan view:clear
    $ php artisan route:clear
    $ php artisan config:clear
    $ php artisan cache:clear
    ```

- Install frontend(css,js) dependency libraries and bundle them
  ```
  $ npm install
  $ npm run backend-prod
  $ npm run frontend-prod
  ```

#### Use the app

[:arrow_up: Back to top](#index)

- Website: [http://localhost:8000](http://localhost:8000)
- App login: [http://localhost:8000/login](http://localhost:8000/login)

  | Username   | Password |
  | ---------- | :------- |
  | superadmin | super99  |
  | admin      | demo123  |


