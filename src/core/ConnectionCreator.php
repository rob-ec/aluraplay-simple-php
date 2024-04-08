<?php

namespace Rob\Aluraplay\Core;

use PDO;
use PDOException;

class ConnectionCreator
{
    private static string $dbLib = "sqlite";
    private static string $dbPath = __DIR__ . "/../../database/db.sqlite";

    /**
     * @throws PDOException
     */
    public static function create(): PDO
    {
        $dsn = self::$dbLib . ':' . self::$dbPath;
        $connection = new PDO($dsn);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}
