#!/usr/bin/env bash
docker-compose -p data-sync-client \
               -f ./docker/client/docker-compose.yml \
               exec php-fpm php app/console datasync:sync
