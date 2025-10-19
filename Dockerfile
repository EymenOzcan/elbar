# -----------------------------
# Stage 1: Builder
# -----------------------------
FROM php:8.2-fpm-alpine AS builder

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Build dependencies
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    bash \
    gcc \
    g++ \
    make \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zlib-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# -----------------------------
# Stage 2: Final Image
# -----------------------------
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
    && rm -rf /var/cache/apk/*

# Copy PHP extensions and vendor from builder
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /app/vendor /app/vendor

# Create app user
RUN addgroup -g 1000 laravel && adduser -D -u 1000 -G laravel laravel

WORKDIR /app

# Copy app code
COPY --chown=laravel:laravel . .

# Create necessary directories
RUN mkdir -p \
    storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    public/images && \
    chown -R laravel:laravel storage bootstrap

# PHP & Nginx config (placeholder, kendi config dosyalarını kullanabilirsin)
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/99-custom.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Generate key and cache configs
USER laravel
RUN php artisan key:generate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 80 9000

# Healthcheck
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
