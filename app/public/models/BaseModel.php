<?php

/**
 * NOTE! this base model handles initializing PDO
 * 
 * To use PDO in a derived class, use self::$pdo
 */

class BaseModel
{
    protected static $pdo;

    function __construct()
    {
        if (!self::$pdo) {
            try {
                // Load environment variables from the environment file
                // This is more reliable than depending on $_ENV
                require_once(__DIR__ . "/../lib/env.php");
                
                $host = $_ENV["DB_HOST"] ?? 'mysql';
                $db = $_ENV["DB_NAME"] ?? 'developmentdb';
                $user = $_ENV["DB_USER"] ?? 'root'; 
                $pass = $_ENV["DB_PASSWORD"] ?? 'secret123';
                
                // Fix for the "Unknown character set" error - use utf8 instead of utf8mb4
                $charset = 'utf8';

                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ];

                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Log the error and provide a helpful message
                error_log("Database connection error: " . $e->getMessage());
                throw new PDOException("Database connection failed: " . $e->getMessage());
            }
        }
    }
}