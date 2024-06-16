# Use the official PHP image.
# https://hub.docker.com/_/php
FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        git \
        curl \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring exif pcntl bcmath opcache

# Limpiar cache de apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar composer.lock y composer.json
COPY composer.lock composer.json /var/www/

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de PHP
RUN composer install --no-scripts --no-autoloader

# Copiar código de la aplicación
COPY . /var/www

# Cargar dependencias de PHP
RUN composer dump-autoload

# Exponer puerto 9000 y arrancar PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
