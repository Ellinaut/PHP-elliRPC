FROM ubuntu:21.10
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV DEBIAN_FRONTEND noninteractive

VOLUME ["/app"]
WORKDIR /app

RUN apt-get update \
&& apt-get install -y curl software-properties-common \
&& add-apt-repository ppa:ondrej/php \
&& apt-get update \
&& apt-get upgrade -y \
&& apt-get install -y \
    git \
    unzip \
    php8.0 \
    php8.0-cli \
    php8.0-curl \
    php8.0-xml \
    php8.0-zip

ENTRYPOINT while true; do sleep 30; done
