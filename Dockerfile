FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Point Apache DocumentRoot directly to /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html/

# Create required directory structure and grant Apache write permissions
RUN mkdir -p /var/www/html/uploads/covers /var/www/html/logs \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80