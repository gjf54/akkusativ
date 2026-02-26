FROM php:8.3-fpm

WORKDIR /var/www/

ARG UID=1000
ARG GID=1000

RUN groupmod -g ${GID} www-data && \
    usermod -u ${UID} -g ${GID} www-data

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/bin/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

RUN docker-php-ext-install mysqli pdo pdo_mysql sockets bcmath

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]