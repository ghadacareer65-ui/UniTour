FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

ENV PHP_CLI_SERVER_WORKERS=6
WORKDIR /app
COPY . /app

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t /app/public"]