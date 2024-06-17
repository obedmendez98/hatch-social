# Usar una imagen base de PHP con FPM
FROM php:8.1-fpm

# Instalar extensiones necesarias de PHP y otras dependencias
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql zip bcmath exif

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto, excepto los que están en .dockerignore
COPY . .

# Establecer permisos correctos para Laravel
RUN chown -R www-data:www-data storage \
    && chown -R www-data:www-data bootstrap/cache

# Verificar si Composer está instalado correctamente
RUN composer --version

# Instalar las dependencias del proyecto
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
