#!/bin/sh

echo "=== VelvetHour API starting ==="

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
    echo "[key] Generating APP_KEY..."
    php artisan key:generate --force 2>&1 || echo "[key] key:generate failed"
fi

# Clear any stale caches first
php artisan config:clear 2>/dev/null || true
php artisan route:clear  2>/dev/null || true

# Cache config and routes
echo "[cache] Caching config..."
php artisan config:cache 2>&1 || echo "[cache] config:cache failed - continuing"
php artisan route:cache  2>&1 || echo "[cache] route:cache failed - continuing"

# Start PHP-FPM as background daemon
echo "[fpm] Starting PHP-FPM..."
php-fpm -D 2>&1
echo "[fpm] PHP-FPM started (port 9000)"

# Start queue workers in background
php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --quiet 2>/dev/null &
php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --quiet 2>/dev/null &
echo "[queue] 2 queue workers started"

# Run DB migrations + seed in background
(
    echo "[db] Waiting for PostgreSQL..."
    RETRIES=0
    until php -r "
        try {
            new PDO(
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
            echo "[db] ERROR: PostgreSQL not reachable after 40 retries — giving up"
            exit 1
        fi
        echo "[db] Retry $RETRIES/40 (3s)..."
        sleep 3
    done

    echo "[db] PostgreSQL connected! Running migrations..."
    php artisan migrate --force 2>&1 && echo "[db] Migrations done"

    echo "[db] Checking seed status..."
    USER_COUNT=$(php -r "
        require '/var/www/html/vendor/autoload.php';
        \$pdo = new PDO(
            'pgsql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'),
            getenv('DB_USERNAME'), getenv('DB_PASSWORD')
        );
        \$stmt = \$pdo->query('SELECT COUNT(*) FROM users');
        echo \$stmt->fetchColumn();
    " 2>/dev/null)

    if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
        echo "[db] Seeding demo data (this takes 1-2 min)..."
        php artisan db:seed --force 2>&1 && echo "[db] Seeding complete!"
    else
        echo "[db] DB already seeded ($USER_COUNT users), skipping"
    fi
) &

# Start NGINX in foreground — keeps container alive
# /up health endpoint is handled by nginx directly (no PHP needed)
echo "[nginx] Starting nginx on port 8080..."
exec nginx -g "daemon off;"
