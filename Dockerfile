FROM mlabfactory/php8-apache:v1.3

# Copy the application files
COPY . /var/www/workdir
COPY ./bin/apache/default.conf /etc/apache2/sites-available/budgetcontrol.cloud.conf

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