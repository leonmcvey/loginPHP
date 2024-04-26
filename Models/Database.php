<?php

require __DIR__ . '/../vendor/autoload.php';

class Database
{
    private $pdo;

    public function __construct()
    {


        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
        $dotenv->load();

        $host = $_ENV["host"];
        $port = $_ENV["port"];
        $dbname = $_ENV["db"];
        $user = $_ENV["user"];
        $pass = $_ENV["pass"];

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);

        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

}


