# DataSync

It's a babymarkt.de Slacktime project by Arkadius Jonczek to sync database table entries from different data source and destination types. It also supports different adapters if neccessary and is fully extensible.

![data-sync](data-sync.png)

## Configuration

Create a parameters.yml file for the server and client configuration.

```bash
cp app/config/parameters.yml.dist app/config/parameters.yml
```

## Test run

Start server and client docker containers:

```
./server.sh up -d
./client.sh up -d
```

Connect to server and client mysql server:

```
Server: 127.0.0.1:33060
Client: 127.0.0.1:33061

User:     root
Password: root
Database: datasync
```

Start sync from server to client:

```
./sync.sh
```

Shutdown docker containers after tests:

```
./client.sh down
./server.sh down
```

## Start Sync

```bash
php app/console datasync:sync
```

## Debug in PhpStorm

### php.ini

1. Open "docker/server/images/php-fpm/php.ini"
2. Set "xdebug.remote_host" to local ip (use ifconfig)

### PhpStorm

1. Go to "Preferences -> Languages & Frameworks -> PHP -> Debug"
2. Set Xdebug Port to 9999
3. Add PHP Remote Debug Entry