<?php
/**
 * Configuration de la connexion à la base de données
 */
return [
    'host'     => '127.0.0.1',
    'dbname'   => 'phama_garde',
    'username' => 'admin',
    'password' => 'admin',
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ],
];
