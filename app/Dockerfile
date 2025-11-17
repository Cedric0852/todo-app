# Multi-stage build: composer + node build + php runtime

FROM composer:2 AS composer
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader || true
COPY . .
RUN composer dump-autoload -o || true

FROM node:20 AS assets
WORKDIR /var/www/html
COPY package*.json vite.config.* ./
COPY resources resources
RUN npm ci || npm install
RUN npm run build || npm run build

FROM php:8.3-cli-alpine
RUN apk add --no-cache sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite
WORKDIR /var/www/html
COPY . .
COPY --from=composer /var/www/html/vendor vendor
COPY --from=assets /var/www/html/public/build public/build
RUN mkdir -p storage bootstrap/cache database \
  && chmod -R 775 storage bootstrap/cache database || true
EXPOSE 8000
CMD ["php","-S","0.0.0.0:8000","-t","public"]
