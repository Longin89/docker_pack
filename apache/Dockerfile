# httpd base image
FROM ubuntu/apache2:latest

# Устанавливаем OpenSSL
RUN apt update && apt install -y openssl

# Создаем директорию для SSL-сертификатов
RUN mkdir -p /etc/apache2/ssl/localhost

# Generate cert
RUN openssl req -new -x509 -days 1461 -nodes -newkey rsa:2048 -out /etc/apache2/ssl/localhost/server.crt -keyout /etc/apache2/ssl/localhost/server.key -subj \
    "/C=RU/ST=SPb/L=SPb/O=Global Security/OU=IT Department/CN=localhost/CN=HomeLab"

# Удаляем стандартный конфигурационный файл Apache
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Copy the Apache virtual host configuration file to the container
COPY ./vhost.conf /etc/apache2/sites-available/apache.vhost.conf

# Создаем символическую ссылку на файл конфигурации виртуального хоста в sites-enabled
RUN ln -s /etc/apache2/sites-available/apache.vhost.conf /etc/apache2/sites-enabled/apache.vhost.conf

# Включаем необходимые модули Apache
RUN a2enmod deflate proxy proxy_fcgi rewrite ssl socache_shmcb http2

# Копируем .htaccess
COPY ./.htaccess /var/www/html/

# Проверяем конфигурацию Apache
RUN apache2ctl -t