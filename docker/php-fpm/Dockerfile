FROM php:7.2-fpm-alpine
RUN apk add --no-cache libxml2-dev freetype-dev && \
    docker-php-ext-install soap gd pdo_mysql opcache  

COPY ./conf/zz-docker.conf /usr/local/etc/php-fpm.d
COPY ./conf/10-docker-opcache-openconext.conf /usr/local/etc/php/conf.d/
CMD ["/usr/local/sbin/php-fpm" , "-F"]
