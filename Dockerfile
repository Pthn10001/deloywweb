FROM php:8.0-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./CothingNew /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
