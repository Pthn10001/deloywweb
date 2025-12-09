FROM php:8.0-apache

# Bật mod_rewrite (nếu code có dùng)
RUN a2enmod rewrite

# Cài extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# Copy composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Thư mục làm việc trong container
WORKDIR /var/www/html

# 🔥 Copy đúng source vào /var/www/html
# (Laravel/PHP app của bạn đang nằm trong CothingNew/CothingNew)
COPY ./CothingNew/CothingNew /var/www/html

# Cài dependency PHP (nếu có composer.json)
RUN if [ -f composer.json ]; then \
      composer install --no-interaction --prefer-dist --optimize-autoloader; \
    fi && \
    mkdir -p storage bootstrap/cache || true && \
    chmod -R 777 storage bootstrap/cache || true

# ❌ KHÔNG chỉnh APACHE_DOCUMENT_ROOT nữa
# Apache mặc định root = /var/www/html, ở đó có index.php của bạn

EXPOSE 80

CMD ["apache2-foreground"]
