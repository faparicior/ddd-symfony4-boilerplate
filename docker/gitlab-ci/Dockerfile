FROM php:7.4-apache-buster

RUN apt -y update \
    && apt -y update \
    && a2enmod rewrite \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin \
    && groupadd -r devel -g 1000 \
    && useradd --no-log-init -u 1000 -r -g devel devel \
    && apt -y install git libzip-dev unzip nodejs npm \
    && npm install npm@latest -g \
    && docker-php-ext-install zip \
    && pecl install xdebug-2.9.4 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && apt -y install libgtk2.0-0 libgtk-3-0 libnotify-dev libgconf-2-4 libnss3 libxss1 libasound2 libxtst6 xauth xvfb

COPY httpd.conf /etc/apache2/sites-enabled/000-default.conf
