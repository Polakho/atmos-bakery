<?php

namespace App\Models;

use App\Classes\Database;
use App\Classes\User;
use PDOException;

class UserModel
{
    private $db;

    public function __construct(){

        $this->db = new Database();
    }
    public function saveUser(user $user){
        $pdo = $this->db->getPDO();
        $object = (array)$user;
        $id = $user->getId();
        if($id === null || $id <= 0){
            try {
                $sql = "INSERT INTO user(name, mail , trash, roles) VALUES (:name, :mail, :trash, :roles)";
                $stmt = $pdo->prepare($sql);

                if ($user->isTrash() === false){
                    $trash = 0;
                }else{
                    $trash = 1;
                }

                $response = $stmt->execute([
                    "name" => $user->getName(),
                    "mail" => $user->getMail(),
                    "trash" => $trash,
                    "roles" => $user -> getRoles(),
                ]) ;
            }catch (PDOException $e) {

                echo  "error :". $e->getMessage();

            }

        }
        $data = (array)$this->getUserById($id);

        $difference = array_diff_assoc($object, $data);
        foreach ($difference as $key => $value) {
            $forTableKey = str_replace(" App\Classes\User ", "", $key);
            $statement = "UPDATE user SET  $forTableKey = '$value' WHERE id = $id";
            $this->db->execute($statement);
        }
    }

    /**
     * @param $id
     * @return User|null
     */
    public function getUserById($id){

        if(!empty($id)){
            try {
                $pdo = $this->db->getPDO();
                $stmt = $pdo->query("SELECT * FROM user WHERE id = $id");
                return $stmt->fetchObject('App\Classes\User');
            }catch (PDOException $e) {
                echo  "error :". $e->getMessage();
            }
        }
        return null;
    }

    public function getAllUser(){
        $pdo = $this->db->getPDO();
        $sql= "SELECT * FROM user WHERE user.trash = 0";
        $stmt = $pdo->query($sql);
        $users = [];
        while ($user = $stmt->fetchObject("App\Classes\user")) {
            $users[] = $user;
        }
        return $users;
    }

}