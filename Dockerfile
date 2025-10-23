# Используем официальный образ PHP FPM Alpine для легковесности
# ОБНОВЛЕНО: Используем образ 8.4, как запрошено
FROM php:8.4-fpm-alpine

# Устанавливаем системные зависимости
RUN apk update && apk add --no-cache \
    nginx \
    git \
    supervisor \
    mysql-client \
    curl \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    zip \
    && rm -rf /var/cache/apk/*

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем необходимые расширения PHP
# Note: bcmath, pdo_mysql, zip, gd, opcache, etc.
RUN docker-php-ext-install pdo_mysql opcache bcmath zip gd

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем код проекта в контейнер
COPY . /var/www/html

# Устанавливаем права доступа (важно для Composer и работы Laravel)
RUN chown -R www-data:www-data /var/www/html

# Порт, который будет слушать встроенный сервер Laravel (8000)
EXPOSE 8000

# Создаем скрипт для запуска.
# Поскольку в render.yaml используется 'php artisan serve',
# этот Dockerfile просто готовит среду.
# Nginx не запускается явно здесь, он будет проксирован через Render.
