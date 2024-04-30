FROM rakhiazfa/php-swoole:1.0.0

WORKDIR /var/www

COPY . .
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY nginx.conf /etc/nginx/nginx.conf

RUN composer install --optimize-autoloader --prefer-dist --no-dev -o

RUN chown -R www-data:www-data storage \
    && chown -R www-data:www-data bootstrap/cache \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

RUN php artisan optimize

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
