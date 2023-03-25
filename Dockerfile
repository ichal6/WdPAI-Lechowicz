# Użyj oficjalnego obrazu PHP w wersji 8.1 jako bazowego obrazu
FROM php:8.1-fpm

# Aktualizuj repozytoria pakietów i zainstaluj potrzebne pakiety
RUN apt-get update && \
    apt-get install -y \
        git \
        zip \
        unzip \
        libicu-dev \
        libzip-dev

# Włącz wymagane moduły PHP
RUN docker-php-ext-install pdo_mysql intl zip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

# Ustaw katalog roboczy na /var/www/html
WORKDIR /var/www/html

# Skopiuj kod aplikacji do kontenera
COPY . .

# Zainstaluj serwer nginx
RUN apt-get update && \
    apt-get install -y nginx

# Skopiuj plik konfiguracyjny nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Otwórz port 80 w kontenerze
EXPOSE 80

# Uruchom serwer nginx i PHP-FPM
CMD service nginx start && php-fpm
