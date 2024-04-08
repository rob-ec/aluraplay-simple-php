<?php

require 'vendor/autoload.php';

use Rob\Aluraplay\Core\ConnectionCreator;

$connection = ConnectionCreator::create();

try {
    $connection->beginTransaction();
    $connection->exec("CREATE TABLE IF NOT EXISTS videos(id INTEGER PRIMARY KEY, url TEXT, title TEXT, image_path TEXT);");
    $connection->exec("CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, email TEXT, password TEXT);");
    $connection->commit();
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}