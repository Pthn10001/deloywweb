FROM php:8.0-apache

# Cài extension PHP cần cho Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Laravel nằm trong: CothingNew/CothingNew/
WORKDIR /var/www/html
COPY CothingNew/CothingNew/ /var/www/html/

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && mkdir -p storage bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Use SQLite so Render doesn't need MySQL
RUN mkdir -p database && touch database/database.sqlite

# DocumentRoot = public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
CMD ["apache2-foreground"]
