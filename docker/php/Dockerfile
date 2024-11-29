FROM php:8.2-alpine3.18

RUN apk add --update --no-cache libintl icu icu-dev postgresql-dev pcre-dev $PHPIZE_DEPS \
    && docker-php-ext-install intl pdo pdo_pgsql pdo_mysql \
    && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && sed -i 's/variables_order = "GPCS"/variables_order = "EGPCS"/g' /usr/local/etc/php/php.ini-*

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -s https://getcomposer.org/installer | php
RUN alias composer='php composer.phar'

WORKDIR /code
COPY . .

EXPOSE 9000

CMD ["php", "-S", "0.0.0.0:9000", "-t", "/code/public"]