FROM mlabfactory/php8-apache:v1.4.1

# Copy the application files
COPY . /var/www/workdir

# Set the working directory
WORKDIR /var/www/workdir

# Install the dependencies
RUN composer install --no-dev --optimize-autoloader
RUN mkdir -p storage/logs
RUN touch .env

# Expose the port
EXPOSE 80

# Start the server
CMD ["apache2-foreground"]

# End of Dockerfile