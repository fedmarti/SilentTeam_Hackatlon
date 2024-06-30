# syntax=docker/dockerfile:1
FROM apache2:php
WORKDIR /var/www
RUN apt-get insatall php8.1
RUN apt-get install php-fpm
RUN a2dissite * --purge -q 
RUN apt install libapache2-mod-php
RUN a2enmod php
RUN a2enmod proxy proxy_fcgi
COPY .apache_config_files/cleaf.conf /etc/apache2/sites-available/cleaf.conf
COPY .apache_config_files/php8.1.conf /etc/apache2/mods-abailable/php8.1.conf
COPY .apache_config_files/ports.conf /etc/apache2/ports.conf
RUN systemctl restart apache2
RUN systemctl enable php8.1-fpm
RUN systemctl start php8.1-fpm
EXPOSE 5000