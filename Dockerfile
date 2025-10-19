# Stage 1 - Builder
FROM php:8.2-fpm-alpine AS builder

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

# Install build dependencies
RUN apk add --no-cache \
        curl \
        git \
        zip \
        unzip \
        postgresql-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        zlib-dev \
        gcc \
        g++ \
        make \
        bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files and install
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Stage 2 - Runtime
FROM php:8.2-fpm-alpine

ENV APP_ENV=production \
    APP_DEBUG=false \
    COMPOSER_ALLOW_SUPERUSER=1

# Runtime dependencies
RUN apk add --no-cache \
        postgresql-client \
        libpng \
        libjpeg-turbo \
        freetype \
        zlib \
        nginx \
        supervisor \
        bash \
    && docker-php-ext-install pdo pdo_pgsql gd

# Create app user
RUN addgroup -g 1000 laravel && adduser -D -u 1000 -G laravel laravel

WORKDIR /app

# Copy built PHP extensions and vendor
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /app/vendor /app/vendor

# Copy app code
COPY --chown=laravel:laravel . .

# Storage & bootstrap permissions
RUN mkdir -p \
        /app/storage/logs \
        /app/storage/framework/cache \
        /app/storage/framework/sessions \
        /app/storage/framework/views \
        /app/bootstrap/cache \
        /app/public/images && \
    chown -R laravel:laravel /app/storage /app/bootstrap && \
    chmod -R 755 /app/storage /app/bootstrap

# PHP, Nginx, Supervisor configs
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/99-custom.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Generate app key & cache (ignore errors)
USER laravel
RUN php artisan key:generate --force || true && \
    php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true

EXPOSE 80 9000

# Healthcheck
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
