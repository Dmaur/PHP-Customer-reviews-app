# install node
FROM node:latest AS node

# install php
FROM php:8.4-apache

# copy nodejs binaries to php image
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
# create symlink for npm to the nodejs binary - allows npm to be run globally from the command line
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# install php extensions, enable xdebug and enable apache mod_rewrite
RUN apt-get update && apt-get install -y libicu-dev git zip \
    && docker-php-ext-install pdo pdo_mysql intl opcache \
    && a2enmod rewrite

# copy config files to the image
COPY ./php/ini/php.ini /usr/local/etc/php/
COPY ./php/ini/upload.ini /usr/local/etc/php/conf.d/
COPY ./apache/000-default.conf /etc/apache2/sites-available/

# Install Composer and copy to php bin path, making it globally available
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# copy the composer files to the image
COPY ./app/composer.* ./

# allow super user - set this if you use Composer as a
# super user at all times like in docker containers
ENV COMPOSER_ALLOW_SUPERUSER=1

# install composer dependencies
RUN composer install --no-scripts --no-autoloader --prefer-dist

# optimize the autoloader
RUN composer dump-autoload --optimize

# copy app files to the image
COPY ./app .

COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# install node modules
RUN npm install

# run npm build
RUN npm run build

CMD ["apache2-foreground"]
