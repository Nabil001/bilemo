# BileMo
=============================
## Prerequisites
It it strongly recommanded to install [composer](https://getcomposer.org/) and git(https://git-scm.com/) in order to properly install this project.
You also need to install [openssl](https://www.openssl.org/) for generating public and private keys, instrumental to authentication.
## Installation
- Download the project (git makes it easy).
```
git clone https://github.com/Nabil001/snowtricks.git
```
- Set the current working directory to the root of the project, then run install the dependencies using composer.
```
composer install
```
- A .env file should be created next to the .env.dist file, and should look alike.
- Set your database URL in the .env file (the database structure will be created later).
```
# .env

DATABASE_URL=mysql://root:@127.0.0.1:3306/bilemo
```
- If needed, you can adjust Doctrine settings in the doctrine.yaml file located in config/packages/ (MySQL driver is set by default).
```
# config/packages/doctrine.yaml

doctrine:
    dbal:
        driver: 'pdo_mysql'
        server_version: '5.7'
        charset: utf8mb4
```
- Create the database.
```
php bin/console doctrine:schema:create
php bin/console doctrine:schema:update --force
```
- Load the fixtures written in the src/DataFixtures/Fixtures.php file.
```
php bin/console doctrine:fixtures:load
```
- Last step is about creating the public and private keys, used for encoding and decoding JSON web tokens. Run these commands from the root folder (you can use whatever passphrase you want, but it must match with JWT_PASSPHRASE variable located in the .env file).
```
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
- JWT_TOKEN_TTL variable from the .env file allows you to easily modify the time to live for generated tokens (time is to be set in seconds, so 3600 if the time to live is an hour).
```
# .env

JWT_TOKEN_TTL=10800
```
- You can finally run the app, using for example Symfony's web server.
```
php bin/console server:run localhost:8000
```
The app is now ready to be used!
