FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql

# Install dependencies for GD and PNG support
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev

# Install GD extension for PHP
RUN docker-php-ext-install gd