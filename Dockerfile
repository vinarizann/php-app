FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

RUN composer install --no-interaction

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app/src"]