ARG VERSION=$VERSIOM

# Development image
FROM php:${VERSION}-fpm AS dev

## Install system dependencies
RUN apt-get update && \
    apt-get install -y nodejs npm apt-utils libpq-dev g++ zlib1g-dev libicu-dev vim git zip gcc make autoconf

RUN apt-get update && \
  DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libzip-dev


#RUN apk update && \
#    apk add --no-cache --virtual dev-deps git autoconf gcc g++ make && \
#    apk add --no-cache zlib-dev libzip-dev

## Install php extensions
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo pdo_mysql zip intl opcache

COPY ./docker/php-fpm/default.ini /usr/local/etc/php/conf.d/default.ini

#ENV APP_ENV=dev
WORKDIR /app

## Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Test image
FROM dev AS test

WORKDIR /app

## Copy project files to workdir
COPY . .

## Install application dependencies
RUN composer install --no-interaction --optimize-autoloader

## Change files owner to php-fpm default user
#RUN chown -R www-data:www-data .

# Prod image
FROM test AS prod

ENV APP_ENV=prod
WORKDIR /app

## Remove dev dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

## Disable xdebug on production
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

## Cleanup
RUN apk del dev-deps && \
    composer global remove hirak/prestissimo && \
    rm /usr/local/bin/composer