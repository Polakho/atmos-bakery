<?php

namespace App\Classes;

use PDO;
use Dotenv\Dotenv;

class Database
{


    private $dotenv;

    public function __construct()
    {

        $this->dotenv  = Dotenv::createImmutable(__DIR__ . "/../../");
    }

    public function getPDO()
    {

        $this->dotenv->load();
        $dbName = $_ENV["DB_NAME"];
        $username = $_ENV["PDO_USERNAME"];
        $password = $_ENV["PDO_PASSWORD"];
        $server = $_ENV["SERVER"];
        $dbPort = $_ENV["DB_PORT"];

        $pdo = new PDO("mysql:dbname=$dbName;host=$server;port=$dbPort", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public function query($statement)
    {
        $req = $this->getPDO()->query($statement);
        $datas = $req->fetchAll();
        return $datas;
    }

    public function execute($statement)
    {
        return $execute = $this->getPDO()->exec($statement);
    }
}
