FROM phpswoole/swoole

RUN apt-get update && apt-get install -y \
    curl \
    libcurl4-openssl-dev \
    libssl-dev \
    pkg-config \
    libzip-dev \
    zlib1g-dev \
    libicu-dev \
    libidn2-0-dev \
    libidn11-dev \
    libevent-dev \
    g++ \
    zip \
    && docker-php-ext-install zip && apt-get clean

RUN apt-get update && apt-get install -y \
    procps \
    && docker-php-ext-install pcntl

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Устанавливаем расширение raphf через PECL
RUN pecl install raphf && docker-php-ext-enable raphf

RUN pecl install pecl_http && docker-php-ext-enable http

RUN composer self-update
