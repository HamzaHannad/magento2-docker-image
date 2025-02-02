ARG PHP_IMAGE

FROM ${PHP_IMAGE} AS php-fpm

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
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get update && apt-get install -y nodejs npm

# Install mhsendmail for Mailhog integration
RUN curl -L https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail_linux_amd64 \
    && chmod +x mhsendmail_linux_amd64 \
    && mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail

# Configure PHP to use mhsendmail
RUN echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/mailhog.ini

# Install composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Install blackfire prob
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini

# Setting the user
RUN groupadd -g ${group_id} ${group_name} \
 && useradd -g ${group_id} -u ${user_id} -d /var/www -s /bin/bash ${user_name}
RUN mkdir -p /var/www/html \
   && chown -R ${user_name}:${group_name} /var/www

USER ${user_name}:${group_name}
VOLUME /var/www
WORKDIR /var/www/html