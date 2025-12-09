FROM php:8.0-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ✅ Lưu ý: Laravel nằm trong CothingNew/CothingNew nên phải copy như sau:
COPY ./CothingNew/CothingNew /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && chmod -R 777 storage bootstrap/cache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
