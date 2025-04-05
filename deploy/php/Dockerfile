FROM phpdockerio/php:8.4-fpm

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.4-amqp \
        php8.4-bcmath \
        php8.4-bz2 \
        php8.4-http \
        php8.4-imap \
        php8.4-mcrypt \
        php8.4-mongodb \
        php8.4-pgsql \
        php8.4-redis \
        php8.4-xdebug \
        php8.4-yaml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /usr/local/src
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

WORKDIR "/opt/app"