FROM php:8-fpm-alpine

RUN mkdir -p /var/www/html

COPY . /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN sed -i "s/user = www-data/user = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-install pdo pdo_mysql

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

RUN rm -rf /var/lib/apt/lists/*
RUN apk add --no-cache \
    git \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libjpeg \
    libmcrypt-dev \
    libgd \
    jpegoptim optipng pngquant gifsicle \
    libxml2-dev \
    zip \
    sudo \
    unzip \
    npm \
    nodejs \
    zlib-dev \
    libzip-dev \
    autoconf \
    g++ \
    imagemagick-dev \
    make \
    && pecl install imagick \
    && docker-php-ext-enable imagick
    
# Clear cache
RUN  rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql exif pcntl bcmath gd zip

# Clear cache
RUN rm -rf /var/cache/apk/*

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
