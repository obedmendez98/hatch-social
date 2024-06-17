# Usar una imagen base de PHP con FPM
FROM php:8.1-fpm

# Instalar extensiones necesarias de PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto
COPY . .

# Instalar las dependencias del proyecto
RUN composer install

# Establecer permisos correctos para Laravel
RUN chown -R www-data:www-data storage
RUN chown -R www-data:www-data bootstrap/cache

# Exponer el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
