FROM php:8.1-rc-fpm AS php-fpm

ARG group_name=app
ARG group_id=1000
ARG user_name=app
ARG user_id=1000

# Install required php extensions
RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libzip-dev \
		libicu-dev \
		libxml2-dev \
		libxslt-dev \
		unzip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install gd \
	&& docker-php-ext-install bcmath \
	&& docker-php-ext-install pdo_mysql \
	&& docker-php-ext-install sockets \
	&& docker-php-ext-install zip \
	&& docker-php-ext-install sockets \
	&& docker-php-ext-install intl \
	&& docker-php-ext-install soap \
	&& docker-php-ext-install xsl \
	&& docker-php-ext-install pdo_mysql
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY docker-php-ram-limit.ini /usr/local/etc/php/conf.d/

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Install Nodejs
ENV NODE_VERSION=16.14
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

# Install composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Setting the user
RUN groupadd -g ${group_id} ${group_name} \
 && useradd -g ${group_id} -u ${user_id} -d /var/www -s /bin/bash ${user_name}
RUN mkdir -p /var/www/html \
   && chown -R ${user_name}:${group_name} /var/www

USER ${user_name}:${group_name}

VOLUME /var/www
WORKDIR /var/www/html