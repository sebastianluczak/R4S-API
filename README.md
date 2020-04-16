# Instalation

Project is using [Docker](https://docs.docker.com/compose/install/). Mind that if you're using Windows Home Docker is kinda funky with it and I recommend upgrading to Windows Pro or Enterprise (or just use Linux instead).

```shell script
$ git pull https://github.com/sebastianluczak/R4S-API.git
$ cd R4S-API
$ docker-compose up -d
```

Create JWT certificates:

```shell script
$ docker exec -it ready4s-php-fpm bash
# mkdir -p config/jwt
# echo "$jwt_passphrase" | openssl genpkey -out config/jwt/private.pem -pass stdin -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
# echo "$jwt_passphrase" | openssl pkey -in config/jwt/private.pem -passin stdin -out config/jwt/public.pem -pubout
```

// TODO