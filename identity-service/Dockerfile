FROM php:8.3-fpm-alpine

RUN apk update && \
    apk add --no-cache libmcrypt-dev nginx supervisor

RUN docker-php-ext-install pdo pdo_mysql pcntl \
    && docker-php-ext-enable pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p "/etc/supervisor/logs" \
    && mkdir -p "/var/log/nginx"

WORKDIR /var/www

COPY . .

RUN chown -R www-data:www-data storage \
    && chown -R www-data:www-data bootstrap/cache \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

RUN composer install --ignore-platform-reqs --optimize-autoloader --prefer-dist --no-dev -o

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY nginx.conf /etc/nginx/nginx.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]