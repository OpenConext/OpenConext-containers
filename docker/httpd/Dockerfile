FROM httpd:2.4-alpine AS httpd-build
MAINTAINER Bart Geesink (bart.geesink@surf.nl)
RUN mkdir -p /var/www/html/
COPY ./conf/httpd.conf /usr/local/apache2/conf/
EXPOSE 80
CMD ["httpd", "-D", "FOREGROUND"]
