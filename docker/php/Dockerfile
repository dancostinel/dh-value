FROM php:8.2.0-fpm
RUN apt-get update && apt-get install apt-file -y && apt-file update && apt-get install vim -y --no-install-recommends \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
        wget \
    && docker-php-ext-install \
        iconv \
        zip \
        intl \
        mysqli \
        pdo pdo_mysql \
        bcmath \

RUN apt-get update && apt-get install -y \
	netcat \
	zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
WORKDIR /var/www/empty-project/
