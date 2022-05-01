<?php

namespace App;

use PDO;

class Database
{


    public function __construct(){

    }

    private function getPDO(){

            $pdo = new PDO("mysql:dbname=Atmos_Bakery;host=localhost", "root", "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public function query($statement){
        $req = $this->getPDO()->query($statement);
        $datas = $req->fetchAll(PDO::FETCH_OBJ);
        return $datas;
    }

}

