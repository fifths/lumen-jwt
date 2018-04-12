# Lumen with JWT Authentication demo

## What's Added
- [Lumen 5.6](https://github.com/laravel/lumen/tree/v5.6.0)
- [JWT Auth](https://github.com/tymondesigns/jwt-auth)
- [Dingo](https://github.com/dingo/api)

## Quick Start
- `git clone`
- Run `composer install`
- `cp .env.example .env` and configure .env
- `php artisan jwt:secret`
- `php artisan migrate`

```sh
php -S 0.0.0.0:8000 -t ./public
```

```
apidoc -i app/Http/Controllers/ -o apidoc/
```
