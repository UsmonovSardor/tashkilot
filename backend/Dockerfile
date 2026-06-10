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
    # Required for pecl extensions
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
    # Install Redis extension via pecl (needs autoconf/make/g++)
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Clean up build tools to reduce image size
    && apk del autoconf g++ make linux-headers \
    && rm -rf /tmp/pear

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Supervisord config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Startup script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh \
    && mkdir -p /var/log/supervisor /var/log/nginx

WORKDIR /var/www/html

# Copy composer files first for Docker layer caching
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN composer install \
    --no-interaction \
    --no-scripts \
    --no-dev \
    --optimize-autoloader \
    --prefer-dist

# Copy application code
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && php artisan storage:link 2>/dev/null || true

EXPOSE 8080

CMD ["/start.sh"]
