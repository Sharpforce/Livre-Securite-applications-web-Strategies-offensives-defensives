FROM debian:12

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y \
    apache2 \
    php \
    php-mysql \
    php-curl \
    php-xml && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN sed -i 's/allow_url_include = Off/allow_url_include = On/' /etc/php/8.2/apache2/php.ini


WORKDIR /var/www/html

COPY . .

RUN rm -f index.html && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www

EXPOSE 80

CMD ["apachectl", "-D", "FOREGROUND"]