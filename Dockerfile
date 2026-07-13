FROM php:8.3-apache

# Install extension yang dibutuhkan (json sudah built-in, tidak perlu install)
RUN docker-php-ext-install mbstring

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy semua file
COPY . /var/www/html/

# Set permission
RUN chown -R www-data:www-data /var/www/html/ && \
    chmod -R 755 /var/www/html/ && \
    chmod 777 /var/www/html/data.json

# Set server name biar ga warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80
