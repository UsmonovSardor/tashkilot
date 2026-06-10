#!/bin/sh

echo "=== VelvetHour API starting ==="

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
    echo "[key] Generating APP_KEY..."
    php artisan key:generate --force 2>/dev/null || true
fi

# Cache config and routes (non-blocking, ignore errors)
echo "[cache] Caching config..."
php artisan config:cache 2>/dev/null && echo "[cache] Config cached" || echo "[cache] Config cache skipped"
php artisan route:cache  2>/dev/null && echo "[cache] Routes cached" || echo "[cache] Route cache skipped"

# Start PHP-FPM as background daemon
echo "[fpm] Starting PHP-FPM..."
php-fpm -D
echo "[fpm] PHP-FPM started"

# Start queue workers in background (2 workers, no supervisord needed)
php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --quiet &
php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --quiet &
echo "[queue] 2 queue workers started"

# Run DB migrations + seed in background
(
    echo "[db] Waiting for PostgreSQL..."
    RETRIES=0
    until php -r "
        try {
            \$pdo = new PDO(
                'pgsql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD'),
                [PDO::ATTR_TIMEOUT => 5]
            );
            echo 'ok';
        } catch(Exception \$e) { exit(1); }
    " 2>/dev/null | grep -q ok; do
        RETRIES=$((RETRIES + 1))
        if [ $RETRIES -ge 40 ]; then
            echo "[db] ERROR: PostgreSQL not reachable after 40 retries"
            exit 1
        fi
        echo "[db] Retry $RETRIES/40..."
        sleep 3
    done

    echo "[db] PostgreSQL connected! Running migrations..."
    php artisan migrate --force 2>&1 && echo "[db] Migrations done"

    echo "[db] Checking if seeding needed..."
    USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -1 | tr -d '[:space:]')
    echo "[db] Current user count: '$USER_COUNT'"

    if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
        echo "[db] Seeding demo data..."
        php artisan db:seed --force 2>&1 && echo "[db] Seeding complete!"
    else
        echo "[db] DB already has data ($USER_COUNT users), skipping seed"
    fi
) &

# Start NGINX in foreground — this keeps the container alive
# exec replaces the shell, so nginx is PID 1 of this process
echo "[nginx] Starting nginx on port 8080..."
exec nginx -g "daemon off;"
