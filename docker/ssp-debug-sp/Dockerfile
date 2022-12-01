FROM webdevops/php-nginx:7.2 AS ssp-debug-sp
MAINTAINER Michiel Kodde (michiel@ibuildings.nl)

# Install required applications & binaries to install SimpleSAMLphp
RUN apt-get update && apt-get install -y git python zip libpng-dev nodejs
RUN docker-php-ext-install pdo_mysql exif gd

# Install Composer
COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer
# Install SSP: Clone and install rev adf1eb8 of SSP
WORKDIR /app/
RUN git clone https://github.com/simplesamlphp/simplesamlphp.git /app
RUN git reset --hard adf1eb8

# Install SSP: Copy files
COPY conf/config.php /app/config/config.php
COPY conf/authsources.php /app/config/authsources.php
COPY conf/accountgen.inc /app/config/accountgen.inc
COPY conf/saml20-idp-hosted.php /app/metadata/saml20-idp-hosted.php
COPY conf/saml20-idp-remote.php /app/metadata/saml20-idp-remote.php
COPY conf/saml20-sp-remote.php /app/metadata/saml20-sp-remote.php
COPY conf/SURFconext_short_to_urn.php /app/attributemap/SURFconext_short_to_urn.php

# Install SSP: Install dependencies and build
RUN composer require simplesamlphp/simplesamlphp-module-saml2debug
RUN composer install --prefer-dist -n -o

# Install SSP: Copy DebugSP files
COPY conf/DebugSP /app/modules/DebugSP
COPY conf/sp.php /app/www/sp.php
COPY conf/sp-config.inc /app/www/sp-config.inc
COPY conf/sp-utils.inc /app/www/sp-utils.inc

# Enable the SSP IdP
RUN touch modules/exampleauth/enable

# Configure the webserver: deploy the nginx vhost config & set php-fpm pool config
COPY conf/nginx.conf /opt/docker/etc/nginx/vhost.conf
RUN echo '' > /opt/docker/etc/nginx/vhost.common.d/10-php.conf
