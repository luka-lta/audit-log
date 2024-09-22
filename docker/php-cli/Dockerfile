FROM composer:2.3 AS composer

################################################################################

FROM php:8.3-cli-alpine AS base

# Project dependencies
RUN apk add \
    autoconf \
    build-base \
    openssl-dev \
    icu-dev \
 && docker-php-ext-install -j$(nproc) opcache pdo pdo_mysql bcmath pcntl \
 && apk del \
    autoconf \
    build-base \
    openssl-dev \
 && rm -rf \
    /var/cache/apk/* \
    /tmp/pear

# add user
RUN adduser --disabled-password --no-create-home --home /app/ --gecos '' app
WORKDIR /app/
RUN chown -R app:app /app/ \
 && mkdir -p /app/php-file-cache/

################################################################################

FROM base as build

# composer dependencies
RUN apk add git unzip \
 && rm -rf /var/cache/apk/*

# composer kopieren
COPY --from=composer /usr/bin/composer /usr/bin/composer

# composer.json und composer.lock kopieren
COPY --chown=app:app composer.* /app/

# composer install
USER app
RUN /usr/bin/composer install --no-progress --no-scripts

USER root

################################################################################

FROM base as development

# xdebug
RUN apk add autoconf gcc build-base linux-headers \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && apk del autoconf gcc build-base
COPY ./docker/php-cli/php-xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini
COPY ./docker/php-cli/php-custom.ini $PHP_INI_DIR/conf.d/custom.ini
EXPOSE 9000

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY --chown=app:app --from=build /app /app
COPY --chown=app:app . /app
USER app

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./docker/php-cli/php-opcache-jit-dev.ini $PHP_INI_DIR/conf.d/php-opcache-jit-dev.ini
################################################################################
