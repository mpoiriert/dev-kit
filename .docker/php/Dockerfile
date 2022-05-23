FROM php:7.4.3-fpm

USER root

#COMPOSER
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
	mv composer.phar /usr/local/bin/composer
ENV COMPOSER_MEMORY_LIMIT -1

#GIT for composer
RUN apt-get update \
    && apt-get install -y --no-install-recommends git

#ZIP for github distribution source
RUN apt-get update \
    && apt-get install -y --no-install-recommends zip unzip libzip-dev

#REDIS
RUN pecl install redis && docker-php-ext-enable redis

ARG PUID=1000
ARG PGID=1000

ENV PUID ${PUID}
ENV PGID ${PGID}

RUN usermod -aG sudo dev
RUN echo "dev  ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers
RUN mkdir -p /home/wwwroot && chown -R dev:dev /home/wwwroot /home/dev

USER dev

WORKDIR /home/wwwroot/

EXPOSE 9000
