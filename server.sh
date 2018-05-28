#!/usr/bin/env bash
docker-compose -p data-sync-server \
               -f ./docker/server/docker-compose.yml \
               $@