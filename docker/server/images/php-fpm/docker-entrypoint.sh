#!/usr/bin/env bash

USER_ID=${DOCKER_USER_ID:-1000}

echo "Starting with UID : $USER_ID"
set -x
usermod -u ${USER_ID} www-data

exec "$@"