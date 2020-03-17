FROM php:7.3.11-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libmcrypt-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    autoconf \
    make \
    wget \
    g++ \
    gcc \
    git \
    unzip

RUN curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/60.2/icu4c-60_2-src.tgz && tar -zxf /tmp/icu.tar.gz -C /tmp && cd /tmp/icu/source && ./configure --prefix=/usr/local && make && make install

RUN pecl install -o -f redis xdebug \
    && docker-php-ext-enable redis xdebug \
    && docker-php-ext-configure intl --with-icu-dir=/usr/local \
    && docker-php-ext-configure gd --with-gd --with-jpeg-dir=/usr/local --with-png-dir=/usr/local --with-freetype-dir=/usr/local

RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql opcache intl zip mysqli gd
RUN docker-php-ext-enable mysqli

RUN mkdir /app

WORKDIR /app
