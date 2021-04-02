FROM php:8-fpm

LABEL maintainer="mohammed_hs55@yahoo.com"

# Install dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    locales \
    nodejs \
    npm \
    redis-server \
    supervisor \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mysqli mbstring zip exif pcntl

# install supervisor
# RUN apt-get update && apk add --no-cache supervisor

# enable redis
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install latest version node-js, npm
RUN npm install -g npm@latest

# install requiremnt that needed to make realtime app
# RUN npm install -g laravel-echo-server
# RUN npm --save laravel-echo socket.io-client
# CMD ["laravel-echo-server init"]
# CMD ["laravel-echo-server start"]

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
