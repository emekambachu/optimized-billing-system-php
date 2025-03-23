# Use the official PHP CLI image
FROM php:8.1-cli

# Install system dependencies: git, unzip, and libzip-dev (required for the PHP zip extension)
RUN apt-get update && apt-get install -y git unzip libzip-dev && rm -rf /var/lib/apt/lists/*

# Install the PHP zip extension.
RUN docker-php-ext-install zip

# Set the working directory
WORKDIR /var/www

# Copy composer files into the container
COPY composer.json composer.lock* ./

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies using Composer
RUN composer install --no-interaction --prefer-dist

# Copy the rest of the application code
COPY . .

# Expose port 8080 for the PHP built-in server
EXPOSE 8080

# Start the PHP built-in server serving the public directory
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
