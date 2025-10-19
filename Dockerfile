# Stage 1 - Builder
FROM php:8.2-fpm-alpine AS builder

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Build dependencies
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
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Stage 2 - Final image
FROM php:8.2-fpm-alpine

ENV APP_ENV=production \
    APP_DEBUG=false \
    COMPOSER_ALLOW_SUPERUSER=1

RUN apk add --no-cache \
    postgresql-client \
    libpng \
    libjpeg-turbo \
    freetype \
    zlib \
    nginx \
    supervisor \
    bash \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

WORKDIR /app

# Copy built PHP extensions and vendor
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /app/vendor /app/vendor

# App user
RUN addgroup -g 1000 laravel && adduser -D -u 1000 -G laravel laravel

COPY --chown=laravel:laravel . .

# Storage ve bootstrap cache
RUN mkdir -p /app/storage/logs /app/storage/framework/{cache,sessions,views} /app/bootstrap/cache /app/public/images \
    && chown -R laravel:laravel /app/storage /app/bootstrap \
    && chmod -R 755 /app/storage /app/bootstrap/cache

# PHP, Nginx ve Supervisor config placeholder
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/99-custom.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
USER laravel
ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 80 9000
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
