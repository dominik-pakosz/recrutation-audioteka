# Installation
* `git clone https://github.com/eko/docker-symfony.git`
* `add symfony.localhost to /etc/hosts`
* `cd docker-symfony`
* `git clone https://github.com/pejkosz94/recrutation-audioteka.git symfony`
* `cd symfony`
* `touch .env.local`
* Add variables listed below to .env.local
```
JWT_PASSPHRASE=iloveapi
DATABASE_URL=mysql://symfony:symfony@db:3306/symfony?serverVersion=5.7
```
* `docker-compose up -d --build`
* `docker exec -it php-fpm sh`
* `apk add openssl`
* `composer install`
* `bin/console doctrine:migrations:migrate`
* Generate ssh keys: [use `iloveapi` as phrase]
```
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
* `exit`

# Usage

### Login
* go to `[POST] http://symfony.localhost/api/login`
* use payload listed below:
```
{
   	"username": "admin@gmail.com",
   	"password": "password"
}
```

### Users in database:
Fully functional admin is already in database.

There is API endpoint for creating users (`[POST] http://symfony.localhost/api/users`). Only admin can create users. Payload for this endpoint:
```
{
   	"email": "abc@gmail.com",
   	"plainPassword": "abc"
}
```

# Tests

To run test:
* go to container: `docker exec -it php-fpm sh`
* type `bin/phpunit`
