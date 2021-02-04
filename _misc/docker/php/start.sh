#!/usr/bin/env bash

composer install

wait-for-it database:3306 -t 600

JWT_DIR=$(dirname "${JWT_SECRET_KEY//%kernel.project_dir%/$PWD}")
if [[ ! -d "$JWT_DIR" ]]; then
  mkdir -p "$JWT_DIR"
  chmod 777 "$JWT_DIR"
fi
JWT_SECRET_KEY="${JWT_DIR}/$(basename ${JWT_SECRET_KEY})"
JWT_PUBLIC_KEY="${JWT_DIR}/$(basename ${JWT_PUBLIC_KEY})"
if [[ ! -f "$JWT_SECRET_KEY" ]]; then
  openssl genpkey -out "$JWT_SECRET_KEY" -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:"$JWT_PASSPHRASE"
  openssl pkey -in "$JWT_SECRET_KEY" -out "$JWT_PUBLIC_KEY" -pubout -passin pass:"$JWT_PASSPHRASE"
fi

bin/console doctrine:migrations:migrate --no-interaction
if [[ $(mysql -uroot -p12345 -hmysql playthepage -sse "select count(*) from users;") -eq 0 ]]; then
    bin/console doctrine:fixtures:load --no-interaction
fi

php-fpm
