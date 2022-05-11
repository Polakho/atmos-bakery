<?php

namespace App\Classes;


use App\Database;

class User
{

    private $db;

    /**
     * @param Database $db
     */
    public function __construct(Database $db){

        $this->db = $db;
    }

    public function getUserById($id){

        $user = $this->db->query("SELECT * FROM user WHERE id = $id");

        return $user;
    }

    public function getAllUser(){
        $users = $this->db->query("SELECT * FROM user");

        return $users;
    }
}