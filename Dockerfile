FROM php:8.3-apache

# PHP install
RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        openssl libssl-dev \
        libxml2-dev \
        unzip \
        git

# apache rewrite enabled
RUN cd /etc/apache2/mods-enabled \
    && ln -s ../mods-available/rewrite.load \
    && echo "date.timezone = Asia/Tokyo" > /usr/local/etc/php/php.ini


# Composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

