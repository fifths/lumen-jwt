# Lumen demo

## install
```
composer install
```

cp .env.example .env


## Integrate JWT

```
php artisan jwt:secret
```

```
php artisan migrate

php artisan db:seed
```

## test api

```
curl -X POST -F 'email=user1@example.com' -F 'password=1234' http://localhost:8090/api/auth/token


curl -X POST -H 'Authorization: Bearer Token' -H 'Content-Type: application/json' -d '{"title": "test subject", "content": "some text for the body"}' http://localhost:8090/api/posts
```