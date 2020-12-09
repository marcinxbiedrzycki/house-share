FROM php:7.4-fpm

RUN apt-get update -y \
    && apt-get install -y zip git wait-for-it \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install pdo_mysql opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN echo "[www]\naccess.log = /proc/self/fd/1" \
    > /usr/local/etc/php-fpm.d/yy-access.conf

COPY php.ini /usr/local/etc/php/

WORKDIR /app

COPY start.sh /opt/docker/
RUN chmod +x /opt/docker/start.sh
CMD ["/opt/docker/start.sh"]
