FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/allow_url_include = Off/allow_url_include = On/' /usr/local/etc/php/php.ini

RUN mkdir -p /var/www/html/Livre-Securite-applications-web-Strategies-offensives-defensives

WORKDIR /var/www/html/Livre-Securite-applications-web-Strategies-offensives-defensives

COPY . .

RUN rm -f index.html && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www

USER www-data

EXPOSE 80