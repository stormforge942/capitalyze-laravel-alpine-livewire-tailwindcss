#!/bin/bash
set -e

# First, wait for the database to be ready
echo "Waiting for the database service..."
/usr/local/bin/wait-for-db.sh

echo "running dev entrypoint"

# Run Laravel migrations
echo "Running migrations"
php artisan migrate --force

# Create Default User if not exists
php artisan user:create-fake
echo "test user created"

# Execute the main process
exec php-fpm
