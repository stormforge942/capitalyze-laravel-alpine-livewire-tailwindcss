#!/bin/bash
set -e

echo "running production entrypoint"

# Run Laravel migrations
echo "Running migrations"
php artisan migrate --force

# Create Default User if not exists
echo "Creating default user"
php artisan user:create-fake
echo "test user created"

# Execute the main process
# echo "Starting php-fpm"
# php-fpm -D
# nginx -g 'daemon off;'

php artisan octane:start --host=0.0.0.0 --port=80
