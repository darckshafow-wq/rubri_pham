<?php
/**
 * Classe Database - Singleton de connexion PDO
 */
class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config/database.php';
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s',
                $config['host'], $config['dbname'], $config['charset']
            );
            self::$instance = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        }
        return self::$instance;
    }
}

