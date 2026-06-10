FROM php:8.3-fpm-alpine AS base

# Install system dependencies + build tools (autoconf, make, g++ needed for pecl)
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    bash \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    autoconf \
    g++ \
    make \
    linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        gd \
        opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del autoconf g++ make linux-headers \
    && rm -rf /tmp/pear

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Startup script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh \
    && mkdir -p /var/log/supervisor /var/log/nginx /run

WORKDIR /var/www/html

# Copy composer files first for Docker layer caching
COPY composer.json ./

# Install PHP dependencies (with scripts for package:discover)
RUN composer install \
    --no-interaction \
    --no-dev \
    --optimize-autoloader \
    --prefer-dist \
    --no-scripts

# Copy application code
COPY . .

# Run package discovery and set permissions
RUN composer run-script post-autoload-dump 2>/dev/null || \
    php artisan package:discover --ansi 2>/dev/null || true

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && php artisan storage:link 2>/dev/null || true

EXPOSE 8080

CMD ["/start.sh"]
