FROM serversideup/php:8.3-fpm-nginx

USER root
RUN install-php-extensions gd intl

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data
