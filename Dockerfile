# Base Image
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite and directory index modules
RUN a2enmod rewrite && a2enmod dir

# Copy application source files to the container
COPY . /var/www/html

# Set ServerName to avoid warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 80 for Apache
EXPOSE 80

# Set permissions for the web directory
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 644 /var/www/html/*

# Restart Apache to apply configurations
CMD ["apache2-foreground"]
