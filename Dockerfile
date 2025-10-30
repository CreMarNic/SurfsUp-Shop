# Root-level Dockerfile building the app from the sylius/ subdirectory
FROM php:8.2-apache

# Install required PHP extensions and tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libsqlite3-dev \
    sqlite3 \
    pkg-config \
    zip \
    unzip \
    git \
    curl \
    ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && export PKG_CONFIG_PATH=/usr/lib/x86_64-linux-gnu/pkgconfig:$PKG_CONFIG_PATH \
    && docker-php-ext-configure pdo_sqlite --with-pdo-sqlite=/usr \
    && docker-php-ext-install -j$(nproc) zip pdo pdo_sqlite intl xml gd mbstring opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files first for caching


# Install dependencies (ignore platform to avoid build image mismatches)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction --prefer-dist --ignore-platform-reqs

# Copy application files
COPY composer.json ./
COPY . .

# Create necessary directories and set permissions
RUN mkdir -p var/cache var/log var/sessions \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 var/

# Configure Apache for Sylius
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf \
    && echo '    AllowOverride All' >> /etc/apache2/apache2.conf \
    && echo '    Require all granted' >> /etc/apache2/apache2.conf \
    && echo '</Directory>' >> /etc/apache2/apache2.conf

# Set document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Ensure .htaccess routing
RUN echo 'RewriteEngine On' > /var/www/html/public/.htaccess \
    && echo 'RewriteCond %{REQUEST_FILENAME} !-f' >> /var/www/html/public/.htaccess \
    && echo 'RewriteRule ^(.*)$ index.php [QSA,L]' >> /var/www/html/public/.htaccess

EXPOSE 80
CMD ["apache2-foreground"]


