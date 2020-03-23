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

#Usage

###Users in database:
There is API endpoint for creating users. Only admin can create users, admin credentials:
* username `admin@gmail.com`, password `password`.
Use those credentials to get JWT token from `/api/login` endpoint.
