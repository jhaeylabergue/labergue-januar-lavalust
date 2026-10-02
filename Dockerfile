FROM php:8.3-cli

WORKDIR /var/www/html

RUN docker-php-ext-install pdo_mysql

COPY . .

EXPOSE 10000

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t public public/index.php"]
