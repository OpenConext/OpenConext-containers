FROM php:7.2

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    python \
    zip \
    libpng-dev \
    && docker-php-ext-install pdo_mysql exif gd \
    ## APCu
    && pecl install apcu \
    && pecl install apcu_bc-1.0.3 \
    && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
    && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini

ENV NVM_DIR /usr/local/nvm
ENV NODE_VERSION 14

# Install nvm with node and npm
RUN mkdir $NVM_DIR \
    && curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.39.0/install.sh | bash \
    && . $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default \
    && export INSTALLED_NODE_VERSION=$(nvm version) \
    # Yarn
    && npm install --global yarn

# Composer
COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www
