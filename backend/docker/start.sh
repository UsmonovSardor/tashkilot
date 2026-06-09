#!/bin/sh
set -e

echo "🚀 VelvetHour API starting..."

# Wait for PostgreSQL to be ready
echo "⏳ Waiting for PostgreSQL..."
until php -r "
    try {
        \$pdo = new PDO(
            'pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );
        echo 'connected';
    } catch (Exception \$e) {
        exit(1);
    }
" 2>/dev/null | grep -q connected; do
    echo "PostgreSQL not ready, retrying in 2s..."
    sleep 2
done
echo "✅ PostgreSQL connected"

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Seed only if the companions table is empty (first deploy)
COMPANION_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1 || echo "0")
if [ "$COMPANION_COUNT" = "0" ] || [ -z "$COMPANION_COUNT" ]; then
    echo "🌱 Seeding demo data..."
    php artisan db:seed --force
    echo "✅ Demo data seeded (18 companions, 9 vehicles, 6 venues)"
else
    echo "✅ Database already seeded, skipping"
fi

# Cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ VelvetHour API ready"

# Start supervisord (nginx + php-fpm + queue workers)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
