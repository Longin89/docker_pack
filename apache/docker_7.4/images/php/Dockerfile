# Add PHP-FPM base image
FROM php:7.4-fpm
# Add mysqli && zip && git
RUN apt update -y
RUN apt install -y zip git
RUN docker-php-ext-install pdo mysqli
# ADD composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
