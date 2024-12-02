FROM php:8.2-apache
LABEL authors="carminedev"

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    curl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql mbstring zip gd


RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN cd /var/www/html && \
    mkdir laravel-api-crud

WORKDIR /var/www/html/laravel-api-crud

RUN echo '<VirtualHost *:80>\n\
              DocumentRoot /var/www/html/laravel-api-crud/public\n\
              ServerName localhost\n\
              <Directory /var/www/html/laravel-api-crud/public>\n\
                  AllowOverride All\n\
                  Require all granted\n\
              </Directory>\n\
          </VirtualHost>'\ > /etc/apache2/sites-available/000-default.conf

COPY . .

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/laravel-api-crud/storage /var/www/html/laravel-api-crud/bootstrap/cache

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

RUN composer install --optimize-autoloader --no-dev

EXPOSE 80
