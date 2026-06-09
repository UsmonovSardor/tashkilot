FROM php:8.3-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    redis \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
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
        opcache

# Install Redis PHP extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Supervisord config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html

# Copy composer files first (layer caching)
COPY composer.json composer.lock* ./

# Install PHP dependencies (no dev, optimized)
RUN composer install \
    --no-interaction \
    --no-scripts \
    --no-dev \
    --optimize-autoloader \
    --prefer-dist

# Copy application code
COPY . .

# Generate app key if not set, set permissions
RUN php artisan key:generate --force 2>/dev/null || true \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create storage link
RUN php artisan storage:link 2>/dev/null || true

EXPOSE 8080

# Make startup script executable
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh && \
    mkdir -p /var/log/supervisor /var/log/nginx

CMD ["/start.sh"]
