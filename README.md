# Solita Dev Academy Exercise 2022

Solution for the Solita Dev Academy [farm data exercise](https://github.com/solita/dev-academy-2022-exercise), created to gain some experience with modern PHP frameworks, in this case Laravel.

## Installation

These example installation instructions apply for a WSL2 Ubuntu distribution.

Required packages:
- [PHP8](https://linuxize.com/post/how-to-install-php-8-on-ubuntu-20-04/). Also install php8.0-xml package.
- [Composer](https://getcomposer.org/)
- Docker, either [just for Linux](https://medium.com/geekculture/run-docker-in-windows-10-11-wsl-without-docker-desktop-a2a7eb90556d) or using [Docker Desktop](https://www.docker.com/products/docker-desktop). Also, install docker-compose.

Installation steps:
- Copy or rename .env.example to .env
- Run "composer install" to install PHP depedencies
- Run "./vendor/bin/sail up" to create and start Laravel, MySQL and PHPMyAdmin containers
- In another terminal window, run "./vendor/bin/sail artisan migrate" to create database tables

The application should now be running on [localhost](http://localhost).

## Work Log

- 2021-12-09: Start project, research Laravel beginner basics, simple SQL models for farms and data points. Add PHPMyAdmin to container. (2h)
- 2021-12-10: Farm creation functionality, clear DB functionality. import CSV functionality. (2h)
- 2021-12-11: Authentication with Laravel Breeze. (2h)
- 2021-12-12: Dashboard controller, learning some Tailwind basics. (2h)
- 2021-12-13: Farm removal functionality, get farm functionality, error message component (2h)
- 2021-12-14: Basic charts for location sensor values, better routes (2h)
- 2021-12-15: Set InnoDB Flush Log at TRX Commit 0 to favor insert speed over ACID compliance, show processing time for CSV imports (1h)
- 2021-12-16: Ability to filter measurements by type and date interval (1h)
- 2021-12-17: Add form evaluation for farm controller requests, add ability to change items per page shown for measurements pagination, prettier measurements table form (2h)
- 2021-12-18: Add Font Awesome icons and latest measurements to location details page, move delete location form to location details page, location page chart control form (2h)
- 2021-12-19: Change login forgot password link to registration link, start working on API routes with Sanctum authentication (1h)
- 2021-12-20: Undelete password reset request migration, learn about and implement a couple of simple PHPUnit tests for web routes (3h)
- 2021-12-21: More dashboard route PHPUnit tests, start work on location route PHPUnit tests, data point factory (1h)
- 2021-12-22: Location route PHPUnit tests, DB checks in tests, installation instructions (2h)
- 2021-12-23: More API routes (30min)
- 2021-12-24: Location API route datetime and sensor controls, move API routes to controllers/api (1h)
- 2021-12-25: Wipe data points for location (30min)
- 2021-12-26: Pluralize routes as according to [Laravel best practices](https://github.com/alexeymezenin/laravel-best-practices) (30min)
- 2021-12-27: Move datapoint checks from controller to model, add POST datapoint API route, unique index for datapoints instead of firstOrCreate, unique index for locations instead of firstOrCreate (2h)
- 2021-12-28: Extend dashboard and location tests, tests for API routes (2h)
- 2021-12-29: Delete single measurement functionality, tests, generate API documentation using [Scribe](https://scribe.knuckles.wtf/) (2h)
- 2021-12-30: Move API token routes to different view, better table for location datapoints (2h)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[CMS Max](https://www.cmsmax.com/)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**
- **[Romega Software](https://romegasoftware.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
