<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

- Run `docker compose up`
- Setup database in docker/.env.example if not using docker then use root .env file
- Run `php artisan migrate` inside php container if you use docker.
- Run `npm install`, run this on local system. must have node version 20^ install
- Add current app url to .env file `APP_URL=`
- Run `npm run dev`

To create admin user please run this query after database migration (Type: 1 -> Admin, Type: 0 ->default(student)):
```
INSERT INTO school.users (name, email, email_verified_at, password, remember_token, created_at, updated_at, middle_name,
                          last_name, dob, type)
VALUES ('admin', 'admin@gmail.com', null, '$2y$10$XCVcaeQCGpeCJa1W0iU8eOdFIMDSuGCweykQMvSx59VuFwTFfyAP.', null,
        '2024-08-08 08:47:20', '2024-08-08 09:00:23', 'admin', 'admin', null, 1);
```
**Note**: password - qwQW12!@

Queries :- 

**Generate Reports**: We are currently parsing report data from DOCX files and storing it in a database. However, we are encountering issues with locating the dataset required to generate the report for export.

**Header Removal**: Due to limitations in the parsing library, it is necessary to remove the header from the DOCX file before importing the data. Please ensure that the header is removed to allow the parsing process to work as expected.
