FROM php:7.2-fpm-alpine AS fpmprod
RUN apk add --no-cache libxml2-dev freetype-dev && \
    docker-php-ext-install soap gd pdo_mysql opcache  

COPY ./conf/zz-docker.conf /usr/local/etc/php-fpm.d
COPY ./conf/10-docker-opcache-openconext.conf /usr/local/etc/php/conf.d/
CMD ["/usr/local/sbin/php-fpm" , "-F"]

FROM fpmprod AS fpmdev
COPY --from=composer:1 /usr/bin/composer /usr/bin/composer
COPY ./conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN apk --update --no-cache add git npm yarn autoconf g++ make && \
    docker-php-ext-install exif && \
    pecl install -f xdebug && \
    pecl install -f apcu && \
    pecl install -f apcu_bc && \
    docker-php-ext-enable xdebug apcu apc && \
    apk del --purge autoconf g++ make
CMD ["/usr/local/sbin/php-fpm" , "-F"]
