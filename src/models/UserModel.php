<?php

namespace App\Models;

use App\Classes\Database;
use App\Classes\User;
use App\Classes\Autoloader;
use PDOException;

require "../src/classes/Autoloader.php";
Autoloader::register();

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
                $sql = "INSERT INTO product(name, mail , trash, roles) VALUES (:name, :mail, :trash, :roles)";
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

    public function IsMailAlreadyUsed($mail)
    {
        $pdo = $this->db->getPDO();
        $response = $pdo->prepare("SELECT * FROM user WHERE mail = :mail ");
        $response->execute(
            array(
                "mail" => $mail
            )
        );
        return $response->rowCount() == 0;
    }

    public function CreateNewUser($name, $mail, $password)
    {
        $pass = md5($password);
        $pdo = $this->db->getPDO();
        $response = $pdo->prepare("INSERT INTO user (name, mail, password) values (:name, :mail , :password )");
        $response->execute(
            array(
                "name" => $name,
                "mail" => $mail,
                "password" => $pass
            )
        );
        return $pdo->lastInsertId();
    }

    public function GetUserIdFromMailAndPassword($mail, $password)
    {
        $pdo = $this->db->getPDO();
        $pass = md5($password);
        $response = $pdo->prepare("SELECT id FROM user WHERE mail = :mail AND password = :pass");
        $response->execute(
            array(
                "mail" => $mail,
                "pass" => $pass
            )
        );
        
        $row = $response->fetch();
        return $row;
    }
}