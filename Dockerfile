FROM php:7.4-apache
WORKDIR /var/www

# PHP extensions
RUN apt-get update && \
	apt-get upgrade -y
RUN docker-php-ext-install curl && \
	docker-php-ext-enable curl
RUN apt-get install -y libxslt1-dev && \
    docker-php-ext-install xsl && \
	docker-php-ext-enable xsl
RUN docker-php-ext-install fileinfo && \
	docker-php-ext-enable fileinfo
RUN docker-php-ext-install sockets && \
	docker-php-ext-enable sockets
RUN docker-php-ext-install exif && \
	docker-php-ext-enable exif
RUN docker-php-ext-install intl && \
	docker-php-ext-enable intl
RUN docker-php-ext-install dom && \
	docker-php-ext-enable dom
RUN apt-get install -y libzip-dev && \
	docker-php-ext-install zip && \
	docker-php-ext-enable zip
RUN apt-get update && \
	apt-get upgrade -y

# Farah
RUN mkdir -m 0777 cache
RUN mkdir -m 0777 data
RUN mkdir -m 0777 log
COPY assets assets
COPY scripts scripts
COPY src src
COPY tests tests
COPY public html
COPY config.php config.php
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY composer.json composer.json
COPY composer.lock composer.lock

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev