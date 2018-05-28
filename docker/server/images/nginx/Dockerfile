FROM debian:9.1

MAINTAINER Arkadius Jonczek <arkadius@jonczek.de>

ENV NGINX_VERSION 1.10.3-1+deb9u1

RUN apt-get update \
	&& apt-get install --no-install-recommends --no-install-suggests -y \
						ca-certificates \
						nginx=${NGINX_VERSION} \
						gettext-base \
						procps \
						vim \
	&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

RUN echo "upstream php-fpm {server php-fpm:9000;}" > /etc/nginx/conf.d/upstream.conf

RUN rm /etc/nginx/sites-enabled/default

COPY fastcgi_params /etc/nginx/fastcgi_params
COPY data-sync /etc/nginx/sites-enabled/data-sync

RUN chown -R www-data:www-data /var/www

CMD ["nginx", "-g", "daemon off;"]