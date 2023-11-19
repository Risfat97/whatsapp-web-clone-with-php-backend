FROM php:8.2-apache

ENV APACHE_LOG_DIR   /var/log/apache2/

ARG USER_ID
ARG GROUP_ID

# Update
RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*

# Install useful tools and install important libaries
RUN apt-get -y update && \
    apt-get -y --no-install-recommends install nano wget dialog libsqlite3-dev libsqlite3-0 && \
    apt-get -y --no-install-recommends install zlib1g-dev libzip-dev libicu-dev && \
    apt-get -y --no-install-recommends install --fix-missing apt-utils build-essential git curl && \
    apt-get -y --no-install-recommends install --fix-missing zip unzip openssl && \
    apt-get -y --no-install-recommends install --fix-missing libgd3 libfreetype6 libfreetype6-dev libpng-dev libjpeg-dev && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install phpredis extension
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear

# RUN pecl install -o -f xdebug-3.1.6 \
# && docker-php-ext-enable xdebug

# Other PHP9 Extensions
RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install gettext && \
    docker-php-ext-configure gd --with-jpeg=/usr --with-freetype=/usr && \
    docker-php-ext-enable redis && \
    docker-php-ext-install gd

# To allow .htaccess
RUN a2enmod rewrite
# To allow CORS
RUN a2enmod headers
# To allow CORS
RUN a2enmod proxy_http proxy_wstunnel
# To enable HTTPS
RUN a2enmod ssl

# Default charset for apache2 config
RUN echo 'AddDefaultCharset ISO-8859-1' >> /etc/apache2/conf-enabled/charset.conf;

# Create symbolic link on php exec similar as prod
RUN ln -s /usr/local/bin/php /usr/bin/php8.2

RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data &&\
    chown --changes --silent --no-dereference --recursive \
          --from=33:33 ${USER_ID}:${GROUP_ID} \
        /home/www-data \
;fi

COPY docker/docker-entrypoint.sh /usr/local/bin/docker-php-entrypoint-tmp
RUN chmod a+x /usr/local/bin/docker-php-entrypoint-tmp
ENTRYPOINT ["/usr/local/bin/docker-php-entrypoint-tmp"]
CMD ["apache2-foreground"]

USER www-data
