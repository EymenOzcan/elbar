# Stage 1 - Builder
FROM php:8.2-fpm-alpine AS builder

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Install dependencies
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    postgresql-client \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Stage 2 - Final Image
FROM php:8.2-fpm-alpine

ENV APP_ENV=production \
    APP_DEBUG=false \
    COMPOSER_ALLOW_SUPERUSER=1

# Install runtime dependencies
RUN apk add --no-cache \
    postgresql-client \
    postgresql-dev \
    libpng \
    libjpeg-turbo \
    freetype \
    nginx \
    supervisor \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql opcache

# Create app user
RUN addgroup -g 1000 laravel && adduser -D -u 1000 -G laravel laravel

WORKDIR /app

# Copy PHP built dependencies from builder
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /app/vendor /app/vendor

# Copy application files
COPY --chown=laravel:laravel . .

# Create necessary directories
RUN mkdir -p \
    /app/storage/logs \
    /app/storage/framework/cache \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/bootstrap/cache \
    /app/public/images && \
    chown -R laravel:laravel /app/storage /app/bootstrap

# Configure PHP
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/99-custom.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf

# Configure Nginx
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Configure Supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Generate application key and cache
RUN php artisan key:generate --force || true && \
    php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true

# Set permissions
RUN chown -R laravel:laravel /app && \
    chmod -R 755 /app/storage && \
    chmod -R 755 /app/bootstrap/cache

EXPOSE 80 9000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
