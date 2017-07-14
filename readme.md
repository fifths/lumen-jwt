# Lumen with JWT Authentication demo


## What's Added
- [Lumen 5.4](https://github.com/laravel/lumen/tree/v5.4.0).
- [JWT Auth](https://github.com/tymondesigns/jwt-auth)
- [Dingo](https://github.com/dingo/api)

## Quick Start
- `git clone`
- Run `composer install`
- `cp .env.example .env`
- `php artisan jwt:secret`
- `php artisan migrate`
- `php artisan db:seed`

```sh
php -S 0.0.0.0:8090 -t ./public
```

To authenticate a user

Request:

```sh
curl -X POST -F 'email=user1@example.com' -F 'password=1234' http://localhost:8090/api/auth/token
```


To add post

Request:
```sh
curl -X POST -H 'Authorization: Bearer Token' -H 'Content-Type: application/json' -d '{"title": "test subject", "content": "some text for the body"}' http://localhost:8090/api/posts
```