# Use official PHP 8.2 with Apache base image
FROM php:8.2-apache

# Enable Apache rewrite module (helpful for routing)
RUN a2enmod rewrite

# Install PostgreSQL extension for PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory inside container
WORKDIR /var/www/html

# Copy all project files to container
COPY . /var/www/html

# Set Apache to serve from /public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to use new document root
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Expose port 80 for web traffic
EXPOSE 80
