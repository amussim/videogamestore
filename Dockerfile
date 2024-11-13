# Base Image
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite and directory index modules
RUN a2enmod rewrite && a2enmod dir

# Copy application source files from `site` directory to the container's web root
COPY site/ /var/www/html

# Set ServerName to avoid warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 80 for Apache
EXPOSE 80

# Set permissions for the web directory
RUN find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# Restart Apache to apply configurations
CMD ["apache2-foreground"]
