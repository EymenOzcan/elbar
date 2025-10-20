#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Wait for database to be ready
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "127.0.0.1" ] && [ "$DB_HOST" != "localhost" ]; then
    echo "⏳ Waiting for database at $DB_HOST:${DB_PORT:-3306}..."
    max_attempts=30
    attempt=0

    until nc -z "$DB_HOST" "${DB_PORT:-3306}" || [ $attempt -eq $max_attempts ]; do
        attempt=$((attempt + 1))
        echo "   Database not ready... attempt $attempt/$max_attempts"
        sleep 2
    done

    if [ $attempt -eq $max_attempts ]; then
        echo "⚠️  Warning: Could not connect to database after $max_attempts attempts"
    else
        echo "✅ Database is ready!"
    fi
fi

# Run Laravel optimizations
echo "⚡ Running Laravel optimizations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if AUTO_MIGRATE is set
if [ "$AUTO_MIGRATE" = "true" ]; then
    echo "🔄 Running database migrations..."
    php artisan migrate --force
fi

# Storage link
if [ ! -L /app/public/storage ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# Fix permissions
chown -R laravel:laravel /app/storage /app/bootstrap/cache /app/public 2>/dev/null || true

echo "✅ Laravel application is ready!"

# Execute the main command
exec "$@"
