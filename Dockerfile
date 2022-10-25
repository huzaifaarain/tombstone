FROM php:8.1-fpm-alpine

# Arguments defined in docker-compose.yml
ARG user
ARG uid

RUN apk update; \
    apk upgrade;

# Install system dependencies
RUN apk add \
    git \
    curl \
    libpng-dev \
    jpeg-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    mariadb-client \
    npm \
    oniguruma-dev \
    shadow \
    zsh

RUN docker-php-ext-configure gd --with-jpeg
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath -j$(nproc) gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user

RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)";

