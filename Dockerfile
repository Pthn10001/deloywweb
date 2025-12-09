FROM php:8.0-apache

# Enable rewrite
RUN a2enmod rewrite

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# Copy composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# 🔥 Copy đúng source từ GitHub (KHÔNG có folder con nữa)
COPY ./CothingNew /var/www/html

# Install composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && chmod -R 777 storage bootstrap/cache

# Apache document root → /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
