#!/bin/sh
set -e

if [ ! -d "vendor" ]; then
  echo "Installing dependencies..."
  composer install --optimize-autoloader --no-interaction --prefer-dist
fi

echo "Waiting for PostgreSQL to be ready..."
until php bin/console doctrine:query:sql "SELECT 1" > /dev/null 2>&1; do
  sleep 1
done

php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update --force

exec "$@"