<?php

namespace App\Models;

use App\Classes\Cart;
use App\Classes\Database;
use PDOException;

class CartModel
{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    /**
     * @return Cart|null
     */
    public function getActiveCartForUser($userId){

        if(!empty($userId)){
            try {
                $pdo = $this->db->getPDO();
                $sql = "SELECT * FROM cart WHERE user_id = :userId and status = 1";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    "userId" => $userId
                ]);
                return $stmt->fetchObject('App\Classes\Cart');
            }catch (PDOException $e) {
                echo  "error :". $e->getMessage();
            }
        }
        return null;
    }

    public function saveCart(Cart $cart){
        $pdo = $this->db->getPDO();
        $object = (array)$cart;
        $id = $cart->getId();
        $data = (array)$this->getActiveCartForUser($id);

        $difference = array_diff_assoc($object, $data);
        foreach ($difference as $key => $value) {
            $forTableKey = str_replace(" App\Classes\Cart ", "", $key);
            $statement = "UPDATE cart SET  $forTableKey = '$value' WHERE id = $id";
            $this->db->execute($statement);
        }
    }

    public function createActiveCart($userId){
        $pdo = $this->db->getPDO();
        $sql = "INSERT INTO  cart (user_id, status) VALUES (:user_id, 1)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "user_id" =>  $userId
        ]);

        return $pdo->lastInsertId();
    }

    public function disableCart($cartId){
        $pdo = $this->db->getPDO();
        //prepare
        $sql = "UPDATE cart SET  cart.status = 0 WHERE cart.id = :cartId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "cartId" => $cartId
        ]);
    }
}