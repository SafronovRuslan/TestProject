<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                $host = 'mariadb-11.2';
                $dbname = 'ath';
                $username = 'root';
                $password = '';

                self::$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
