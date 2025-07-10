FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libonig-dev libxml2-dev libpng-dev \
    libsqlite3-dev libpq-dev libjpeg-dev libfreetype6-dev \
    libssl-dev && \
    docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html

# Set working dir
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy custom Apache vhost
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf
