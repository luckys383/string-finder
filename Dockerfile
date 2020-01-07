FROM phpdockerio/php72-fpm:latest

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

COPY . /var/app
WORKDIR /var/app


# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql php-xdebug php7.2-bcmath php7.2-bz2 php7.2-gd php7.2-mbstring php7.2-xml\
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#CMD ls
CMD php artisan serve --port=8000 --host=0.0.0.0