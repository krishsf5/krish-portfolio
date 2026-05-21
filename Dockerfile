FROM php:8.3-apache-bookworm

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:22-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        zip \
    && a2enmod headers rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/render-start.sh /usr/local/bin/render-start.sh

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    && npm ci \
    && npm run build \
    && rm -rf node_modules \
    && chmod +x /usr/local/bin/render-start.sh \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 10000

ENTRYPOINT ["render-start.sh"]
