# Use the official Railway base image.
FROM railwayapp/base:v1.1.3

# Install nginx and PHP-FPM.
RUN apt-get update && \
    apt-get install -y nginx php-fpm && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Copy the nginx configuration file.
COPY .railway/nginx.conf /etc/nginx/sites-available/default

# Copy the application files.
COPY . /app

# Set the working directory.
WORKDIR /app
