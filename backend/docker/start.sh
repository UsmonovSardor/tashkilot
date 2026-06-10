#!/bin/sh
set -e

echo "🚀 VelvetHour API starting..."

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating APP_KEY..."
    php artisan key:generate --force
fi

# Cache config and routes BEFORE starting web server
echo "⚙️  Caching config..."
php artisan config:cache 2>/dev/null || echo "Config cache skipped"
php artisan route:cache  2>/dev/null || echo "Route cache skipped"

# Start supervisord (nginx + php-fpm) immediately
# So healthcheck at /up passes right away
echo "✅ Starting web server (nginx + php-fpm)..."
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf &
SUPERVISOR_PID=$!

# Give nginx/php-fpm 3 seconds to boot
sleep 3
echo "✅ Web server running — healthcheck should pass now"

# Run DB tasks in background (migrations + seeding)
(
    echo "⏳ Waiting for PostgreSQL..."
    RETRIES=30
    COUNT=0
    until php -r "
        try {
            \$dsn = 'pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE');
            new PDO(\$dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT => 5]);
            echo 'ok';
        } catch(Exception \$e) { exit(1); }
    " 2>/dev/null | grep -q ok; do
        COUNT=$((COUNT+1))
        if [ $COUNT -ge $RETRIES ]; then
            echo "❌ PostgreSQL not reachable after ${RETRIES} attempts"
            exit 1
        fi
        echo "   Retry $COUNT/$RETRIES..."
        sleep 3
    done

    echo "✅ PostgreSQL connected"

    echo "🗄️  Running migrations..."
    php artisan migrate --force && echo "✅ Migrations done"

    # Seed only if users table is empty
    USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | grep -E '^[0-9]+$' | tail -1)
    if [ -z "$USER_COUNT" ] || [ "$USER_COUNT" = "0" ]; then
        echo "🌱 Seeding demo data (18 companions, 9 vehicles, 6 venues)..."
        php artisan db:seed --force && echo "✅ Seeding complete"
    else
        echo "✅ Database already has $USER_COUNT users — skipping seed"
    fi

) &

# Keep container alive by waiting on supervisord
wait $SUPERVISOR_PID
