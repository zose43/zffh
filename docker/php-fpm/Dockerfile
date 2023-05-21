FROM php:8.2-fpm-alpine

# rename php.ini
# if err static --> extended output and http code always 200, only for local development
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

WORKDIR /app
