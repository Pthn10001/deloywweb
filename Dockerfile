FROM php:8.0-fpm

# Cài extension
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql gd

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Làm việc trực tiếp trong CothingNew
WORKDIR /var/www/html

# Copy toàn bộ source
COPY ./CothingNew /var/www/html

# Cài đặt Laravel & quyền
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && mkdir -p storage bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache
