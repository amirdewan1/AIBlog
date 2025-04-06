FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libonig-dev libxml2-dev libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    default-mysql-client nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip intl gd

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=prod

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /app

# Copy all project files
COPY . .

# Install Symfony backend deps
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Build React chatbot if inside assets/
RUN npm install && npm run build || echo "No React build found"

# Expose Symfony app
EXPOSE 8000

# Start Symfony server
CMD php -S 0.0.0.0:8000 -t public
