#!/usr/bin/env bash
docker-compose -p data-sync-client \
               -f ./docker/client/docker-compose.yml \
               $@