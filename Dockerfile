# Dockerfile
FROM php:8.4-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    git \
    curl \
    npm \
    nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install Node dependencies and build (jika kamu pakai Vite atau npm build)
RUN npm install && npm run build

# Salin .env.example jadi .env
RUN cp .env.example .env

# Generate APP_KEY
RUN php artisan key:generate

# Expose port 8080 (default Railway HTTP)
EXPOSE 8080

# Start Laravel API
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
