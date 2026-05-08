<?php

namespace App\Core;

class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
            // Updated keys to match your Azure Environment Variables
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '3306';
            $db   = getenv('DB_NAME') ?: 'au_inventory'; // Was DB_DATABASE
            $user = getenv('DB_USER') ?: 'root';         // Was DB_USERNAME
            $pass = getenv('DB_PASS') ?: '';             // Was DB_PASSWORD
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                // Azure MySQL Flexible Server often requires SSL
                \PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt',
            ];

            try {
                self::$connection = new \PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                // This will help you see the exact error in Log Stream
                throw new \PDOException("Connection failed: " . $e->getMessage(), (int) $e->getCode());
            }
        }
        return self::$connection;
    }
}
