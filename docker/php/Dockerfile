FROM    composer:1.8 as composer
FROM    php:7.4-fpm-alpine

COPY    --from=composer /usr/bin/composer /usr/local/bin/composer

# Removing APKINDEX warnings
RUN     rm -rf /var/cache/apk/* && \
        rm -rf /tmp/*
RUN     apk update

# Native libs and building dependencies
# su-exec > gosu (10kb instead of 1.8MB)
RUN     apk add --update --no-cache \
        git \
        unzip \
        make \
        nodejs \
        yarn \
        zlib-dev \
        libzip-dev \
        ca-certificates \
        php-intl \
        && apk add --no-cache --virtual .build-deps \
            $PHPIZE_DEPS \
            curl \
            icu-dev \
        && docker-php-ext-configure intl \
        && docker-php-ext-install \
            zip \
            intl \
            pdo_mysql \
        && yes | pecl install xdebug \
        && apk add --no-cache su-exec \
        && addgroup bar \
        && adduser -D -h /home -s /bin/sh -G bar foo \
        && apk del .build-deps

RUN     version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
        && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
        && mkdir -p /tmp/blackfire \
        && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
        && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
        && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
        && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

# PHP config
COPY    conf.d/php.ini /usr/local/etc/php
COPY    conf.d/symfony.ini /usr/local/etc/php/conf.d