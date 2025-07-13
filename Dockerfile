# Stage 1: Use Composer image to copy composer binary
FROM composer:2.6 AS composer

# Stage 2: Main PHP app image
FROM php:8.3.21-fpm-alpine3.20

ENV NODE_ENV=development

# Create non-root user
RUN addgroup -S developer && adduser -S yourUsernameHere -G developer

# Set working directory
WORKDIR /var/www/html

# Install dependencies and PHP extensions
RUN apk add --no-cache \
    git unzip autoconf make g++ icu-dev libzip-dev zlib-dev \
    libpq postgresql-dev \
 && docker-php-ext-install pdo_pgsql pgsql intl zip \
 && pecl install mongodb \
 && docker-php-ext-enable mongodb

# Copy Composer binary from the composer image
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Copy source code including .env
COPY . .

# Change to non-root user
USER yourUsernameHere

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist

# Expose the port
EXPOSE 8000

# Run the PHP dev server
CMD ["php", "-S", "0.0.0.0:8000", "router.php"]
