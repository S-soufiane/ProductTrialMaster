FROM php:8.2-fpm-alpine

RUN apk add --no-cache postgresql-dev && \
    docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./ /var/www/html

RUN chown -R www-data:www-data /var/www/html

RUN composer install --optimize-autoloader --no-interaction --prefer-dist

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]