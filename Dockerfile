FROM composer:latest

RUN docker-php-ext-install sockets && docker-php-ext-install bcmath

COPY ./composer.json /app

RUN composer install \
	--no-interaction \
	--no-plugins \
	--no-scripts \
	--prefer-dist