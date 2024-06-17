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

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto, excepto los que están en .dockerignore
COPY . .

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer permisos correctos para Laravel
RUN chown -R www-data:www-data storage \
    && chown -R www-data:www-data bootstrap/cache

# Verificar si Composer está instalado correctamente
RUN composer --version
# Instalar dependencias de PHP
RUN composer install --no-scripts --no-autoloader

# Cargar dependencias de PHP
RUN composer dump-autoload

# Exponer puerto 9000 y arrancar PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
