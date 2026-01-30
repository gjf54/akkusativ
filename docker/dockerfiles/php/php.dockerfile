FROM php:8.3-fpm

WORKDIR /var/www/

RUN docker-php-ext-install mysqli pdo pdo_mysql sockets