# Use the official PHP CLI image
FROM php:8.0-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project files
COPY . /var/www

# Install PHP dependencies via Composer
RUN composer install

EXPOSE 8000

# Start PHP's built-in server pointing to the public folder
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
