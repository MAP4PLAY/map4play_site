FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Instalar extensão PHP para PostGIS (pdo_pgsql já instalada acima)
# A extensão pgsql do PHP já suporta PostGIS nativamente

RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/development.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/development.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/development.ini \
    && echo "log_errors = On" >> /usr/local/etc/php/conf.d/development.ini

RUN echo "upload_max_filesize = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 120" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 120" >> /usr/local/etc/php/conf.d/uploads.ini

RUN echo "date.timezone = America/Sao_Paulo" >> /usr/local/etc/php/conf.d/timezone.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/ || exit 1