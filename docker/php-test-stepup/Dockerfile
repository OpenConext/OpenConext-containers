FROM php:7.2

SHELL ["/bin/bash", "-c"]

ARG NPM_UID=1000
ARG NPM_GID=1000

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    python \
    zip \
    libpng-dev \
    wget \
    libgmp-dev \
    re2c \
    libmhash-dev \
    libmcrypt-dev \
    file \
    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include \
    && docker-php-ext-configure gmp \
    && docker-php-ext-install gmp \
    && docker-php-ext-install pdo_mysql exif gd \
    ## Xdebug
    && pecl install xdebug \
    ## APCu
    && pecl install apcu \
    && pecl install apcu_bc-1.0.3 \
    && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
    && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini

RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini

# Xdebug init
COPY ./conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV NVM_DIR /usr/local/nvm
ENV NODE_VERSION 14

# Install nvm
# For reference look at: https://github.com/creationix/nvm#install-script
RUN mkdir -p /usr/local/nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.37.2/install.sh | bash

# Install node and npm
RUN source $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default \
    && npm install -g yarn

# Composer
COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

# Fix npm
RUN mkdir /.npm && chown -R "${NPM_UID}:${NPM_GID}" "/.npm"
RUN mkdir /.config && chown -R "${NPM_UID}:${NPM_GID}" "/.config"


# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
WORKDIR /var/www
