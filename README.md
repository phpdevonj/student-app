<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

### With Docker

- Install docker from [here](https://www.docker.com/)
- clone repo and go to installed directory
- Run `docker compose up`
- Config can be added in `docker/.env.example` file.
- Log in into docker php container with `docker exec -it <container id> /bin/sh`
- Run `php composer install` inside php container.
- Run `php artisan migrate` inside php container.
- Run `php artisan db:seed` to setup admin user.
- Npm is not setup inside docker, so use system npm setup.
- Run `npm install`, run this on local system. must have node version 20^ install
- Add current app url to .env file `APP_URL=` for `vue`.
- Run `npm run dev`
- Assign permission to storage folder
- Access app url in browser

### Without Docker

- Required php^8, mysql or nginx/apache, Node^20 on your system
- clone repo and go to installed directory
- Copy `.env.example` to `.env` on root.
- setup database
- Run `php composer install` to setup project.
- Run `php artisan migrate` to setup db tables.
- Run `php artisan db:seed` to setup admin user.
- Run `npm install`, run this on local system. must have node version 20^ install
- Run `php artisan serve`
- Assign permission to storage folder
- Add current app url to .env file `APP_URL=` for `vue`.
- Access app url in browser

### Login as admin

- Username: `admin@gmail.com`
- Password: `qwQW12!@`

## Version used:

- LARAVEL 9
- VUE 3 (Included in laravel)
- php ^8
- Mysql 8
