FROM php:8.1.0-fpm-alpine

RUN apk add --update --no-cache --virtual .build-deps \
    build-base \
    git \
    autoconf

# Install dependencies
RUN apk add --update --no-cache \
    php-common \
    libressl-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libpng-dev \
    libwebp-dev \
    shadow \
    mariadb-client \
    libintl \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    redis \
    gifsicle \
    unzip \
    curl \
    ffmpeg \
    less


# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Clear cache
RUN rm -rf /var/cache/apk/*

# Install extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install zip

RUN pecl install excimer

RUN docker-php-ext-enable excimer
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath
RUN docker-php-source delete



# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php-local.ini /usr/local/etc/php/conf.d/local.ini
COPY ./php-fpm-www.conf /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /home/php/bank/vendor && chown -R www:www /home/php/bank

COPY --chown=www:www ./ /home/php/bank

# Set working directory
WORKDIR /home/php/bank

USER www

ARG NAMESPACE
RUN if [ "$NAMESPACE" = 'production' ]; then \
    COMPOSER_MEMORY_LIMIT=-1 composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader; \
    else \
    COMPOSER_MEMORY_LIMIT=-1 composer install --no-ansi --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader; \
    fi

USER root

RUN apk del .build-deps

USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
