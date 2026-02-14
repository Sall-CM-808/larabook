FROM node:20-alpine AS assets

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .
COPY --from=assets /app/public/build /app/public/build

RUN composer install --no-dev --optimize-autoloader \
    && php artisan storage:link || true \
    && chmod -R 775 storage bootstrap/cache

RUN chmod +x /app/start.sh

EXPOSE 10000

CMD ["/app/start.sh"]