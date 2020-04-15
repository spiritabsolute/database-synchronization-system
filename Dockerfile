FROM composer:latest AS composer

RUN docker-php-ext-install sockets && docker-php-ext-install bcmath

COPY ./composer.json /app

RUN composer install \
	--no-interaction \
	--no-plugins \
	--no-scripts \
	--prefer-dist

FROM php:7.2-cli

COPY . /app

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=composer /app/vendor /app/vendor

ARG APP=""

ENV APP $APP

WORKDIR /app

COPY entrypoint.sh /

ENTRYPOINT ["/entrypoint.sh"]