# syntax=docker/dockerfile:1
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y libpq-dev git unzip default-mysql-client \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer and install dependencies
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copy the rest of the application
COPY . .

# Install Composer dependencies (optimized for production)
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Set permissions for var directory
RUN chown -R www-data:www-data var

# Expose port 80
EXPOSE 80

# Set the Apache document root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
# Ensure AllowOverride All for .htaccess in the document root
RUN sed -i '/<Directory \/var\/www\/html\/public>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Set default values for DATABASE_HOST, DATABASE_USER, and DATABASE_PASSWORD
ENV DATABASE_HOST=database
ENV DATABASE_USER=root
ENV DATABASE_PASSWORD=admin

# Start with entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Start Apache in the foreground
CMD ["apache2-foreground"] 