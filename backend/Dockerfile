# Menggunakan image PHP dengan FPM
FROM php:8.2-fpm

# Menentukan direktori kerja dalam container
WORKDIR /var/www

# Install dependensi yang diperlukan
RUN apt-get update -y && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    zip \
    git \
    curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql zip bcmath gd

# Menggunakan Composer untuk mengelola dependency Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Menyalin semua file Laravel dari host ke dalam container
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Mengatur izin untuk Laravel storage
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Gunakan user non-root untuk keamanan
RUN usermod -u 1000 www-data
USER www-data

# Expose port untuk PHP-FPM
EXPOSE 9000

# Menjalankan PHP-FPM
CMD ["php-fpm"]

