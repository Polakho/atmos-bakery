<?php

namespace App\Classes;

use PDO;

class Database
{


    public function __construct(){

    }

    public function getPDO(){

        $pdo = new PDO("mysql:dbname=Atmos_Bakery;host=localhost", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public function query($statement){
        $req = $this->getPDO()->query($statement);
        $datas = $req->fetchAll();
        return $datas;
    }

    public function execute($statement){
        return $execute = $this->getPDO()->exec($statement);
    }
}

