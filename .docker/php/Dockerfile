FROM php:8-fpm-alpine

ARG UID=1001
ARG GID=1001

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk add --update --no-cache \
    postgresql-dev \
    shadow \
    && chmod +x /usr/local/bin/install-php-extensions && sync \
    && docker-php-ext-install pdo pdo_pgsql bcmath

RUN usermod -u $UID www-data -s /bin/bash && groupmod -g $GID www-data \
    && rm -rf /tmp/* /var/tmp/* /usr/share/doc/* /var/cache/apk/* /usr/share/php8 \
    && chmod 0777 /var/log -R \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER www-data
WORKDIR /var/www/btc
