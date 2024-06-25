FROM php:8.2-fpm
RUN apt-get update
RUN apt-get install -y curl git zip

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/public_html

ENTRYPOINT ["php-fpm"]
