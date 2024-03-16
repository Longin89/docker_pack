# Add PHP-FPM base image
FROM php:5.4-fpm
# Add mysqli
RUN docker-php-ext-install mysqli
# ADD composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer