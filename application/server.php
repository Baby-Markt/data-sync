<?php
/*
 * Copyright (c) 2017 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Babymarkt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

/* PDO */

$host     = getenv('SERVER_MYSQL_HOST')     ?: 'mysql';
$db       = getenv('SERVER_MYSQL_DATABASE') ?: 'datasync';
$user     = getenv('SERVER_MYSQL_USER')     ?: 'root';
$password = getenv('SERVER_MYSQL_PASSWORD') ?: 'root';

$dsn      = 'mysql:host=' . $host .';dbname=' . $db;
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    echo 'MySQL Connection failed: ' . $e->getMessage();
    exit;
}

/* Data Driver */

$dataSyncApi = new \DataSync\Driver\MySql($pdo);

/* JSON-RPC Server */

$server = new \JsonRPC\Server();

$jsonRpc = new \DataSync\Server\JsonRpc($server);
$jsonRpc->init(
    [
        'api' => $dataSyncApi
    ]
);
echo $jsonRpc->run();