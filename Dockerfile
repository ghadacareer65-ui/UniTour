FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

# إخفاء تحذيرات Deprecated (مكتبة قوقل قديمة) من الشاشة مع إبقائها في اللوغ
RUN printf "display_errors=Off\nlog_errors=On\nerror_reporting=E_ALL & ~E_DEPRECATED & ~E_NOTICE\n" > /usr/local/etc/php/conf.d/app.ini

ENV PHP_CLI_SERVER_WORKERS=6
WORKDIR /app
COPY . /app

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t /app/public"]