FROM php:8.2-cli-alpine

# rename php.ini
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR app/

USER app
