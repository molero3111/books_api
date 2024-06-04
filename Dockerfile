# Use the official PHP image with Apache
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip

# Install project dependencies (if using Composer)
RUN composer install

# Enable modules (adjust based on your needs)
RUN a2enmod rewrite

RUN docker-php-ext-install pdo_pgsql zip

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public


# Expose port 80 (default for Apache)
EXPOSE 80
# Set working directory
WORKDIR /var/www/html

# Copy your Apache configuration (optional, if needed)
# COPY your_apache_config.conf /etc/apache2/sites-available/default.conf

# Restart Apache to apply changes
CMD ["apache2-foreground"]

# Copy your Laravel project files
COPY . .