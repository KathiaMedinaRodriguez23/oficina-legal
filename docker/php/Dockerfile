FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY ./app /var/www

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/vendor \
    && chmod -R 775 /var/www/vendor

RUN php composer.phar install --optimize-autoloader --no-dev

RUN php artisan config:cache && php artisan view:cache && php artisan config:clear && php artisan cache:clear