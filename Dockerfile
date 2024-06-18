# Utilizar la imagen oficial de PHP
FROM php:8.2-fpm

# Instalar dependencias necesarias
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

# Copiar el archivo .env.example y configurar el archivo .env
COPY .env.example .env

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar los archivos del proyecto, excepto los que están en .dockerignore
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-scripts --no-autoloader --prefer-dist --optimize-autoloader

# Establecer permisos correctos para Laravel
RUN chown -R www-data:www-data storage \
    && chown -R www-data:www-data bootstrap/cache \
    && chown -R www-data:www-data vendor

# Cargar dependencias de PHP
RUN composer dump-autoload

# Generar la clave de Laravel
RUN php artisan key:generate --force

# Ejecutar las migraciones de la base de datos
RUN php artisan migrate --force

# Copiar el script de entrada y darle permisos de ejecución
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exponer el puerto 9000 y arrancar PHP-FPM
EXPOSE 9000
# Establecer el script de entrada como CMD
ENTRYPOINT ["docker-entrypoint.sh"]
