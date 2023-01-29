<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

### GoTeam Exam

### Environment
- PHP 8.1
- Laravel 9.48.0

### Setup and Installation
- composer install && npm install
- If docker and sail. Go to project root directory and execute command "./vendor/bin/sail up"
- Run the migrations "php artisan migrate"
- Then execute command "npm run dev"
- Make sure to set CACHE_DRIVER to "redis" in .env
- Lastly go to http://localhost

### Testing
- Create database named "testing" if not defined yet.
- Run the test: php artisan test or sail art test

### Redis
- If you want to clear the pokemons cache you can use this command "docker exec -it container-name redis-cli FLUSHALL"