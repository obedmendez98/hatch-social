#!/bin/bash
set -e

# Copiar el archivo .env si no existe
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Instalar dependencias de Composer
composer install --no-scripts --no-autoloader --prefer-dist --optimize-autoloader

# Generar la clave de Laravel si no está configurada
if ! grep -q "APP_KEY=" .env; then
    php artisan key:generate --force
fi

# Ejecutar migraciones de la base de datos
php artisan migrate --force

# Iniciar PHP-FPM
exec php-fpm
