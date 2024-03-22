# Stage 1: Set up the PHP environment and Composer dependencies
FROM php:8.3-fpm AS php_builder
WORKDIR /app

COPY app/helpers.php /app/app/helpers.php

# Install system dependencies and PHP extensions required for Composer and your application
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    netcat-openbsd \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql mbstring exif pcntl bcmath gd zip
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY auth.json /root/.composer/auth.json

# Copy the Composer files and install PHP dependencies
COPY composer.json composer.lock ./
# Get Composer
# Copy the Laravel source code and the vendor directory
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Stage 2: Build the assets with Node.js
FROM node:16 as node_builder
WORKDIR /app
# Now that PHP dependencies are installed, copy them over as needed for the Node.js build
COPY --from=php_builder /app/vendor ./vendor
# Copy package.json and package-lock.json for npm install
COPY package.json package-lock.json ./
# Install Node.js dependencies
RUN npm install
# Copy the rest of your front-end files
COPY resources/ ./resources/
COPY vite.config.js ./
# Run npm run build to build your assets
RUN npm run build

# Stage 3: Final stage to set up the application
FROM php:8.3-fpm
WORKDIR /var/www

# Install system dependencies, PHP extensions, and PostgreSQL client
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql mbstring exif pcntl bcmath gd
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Copy the built assets from the Node.js stage
COPY --from=node_builder /app/public ./public


COPY --from=php_builder /app/vendor ./vendor

# Permissions adjustments, if necessary
RUN usermod -u 1000 www-data && chown -R www-data:www-data .

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Copy the new wait-for-db script
COPY wait-for-db.sh /usr/local/bin/wait-for-db.sh
RUN chmod +x /usr/local/bin/wait-for-db.sh

# Expose port 9000 and start php-fpm server
EXPOSE 9000
EXPOSE 80
# Set the script as the entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]


RUN echo "Building dev dockerfile"
