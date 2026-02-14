#!/usr/bin/env sh
set -eu

echo "[start] php version: $(php -v | head -n 1)"
echo "[start] PORT=${PORT:-}" 
echo "[start] APP_ENV=${APP_ENV:-}" 
echo "[start] APP_DEBUG=${APP_DEBUG:-}" 

echo "[start] clearing caches (best effort)"
php artisan config:clear >/dev/null 2>&1 || true
php artisan route:clear >/dev/null 2>&1 || true
php artisan view:clear >/dev/null 2>&1 || true

if [ -z "${APP_KEY:-}" ]; then
  echo "[start][error] APP_KEY is missing. Set APP_KEY in Render env vars." >&2
  exit 1
fi

echo "[start] starting php server"
exec php -S 0.0.0.0:${PORT:-10000} -t public public/index.php
