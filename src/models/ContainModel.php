<?php

namespace App\Models;

use App\Classes\Database;
use PDOException;

class ContainModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getContainByProductAndCart($productId, $cartId){
        if (!empty($productId) && !empty($cartId)) {
            try {
                $pdo = $this->db->getPDO();
                $stmt = $pdo->prepare("SELECT * FROM contain WHERE product_id = :productId and cart_id = :cartId");
                $stmt->execute([
                    "productId" => $productId,
                    "cartId" => $cartId
                ]);
                return $stmt->fetchObject('App\Classes\Contain');
            } catch (PDOException $e) {
                echo  "error :" . $e->getMessage();
            }
        }
        return null;
    }

    public function ajouterContain($quantity, $productId, $cartId){
        $pdo = $this->db->getPDO();
        $contain = $this->getContainByProductAndCart($productId, $cartId);
        if ($contain == null) {
            try {
                $sql = "INSERT INTO  contain (quantity, trash, product_id, cart_id) VALUES (:quantity, 0, :productId, :cartId)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    "quantity" => $quantity,
                    "productId" => $productId,
                    "cartId" => $cartId
                ]);

                return $pdo->lastInsertId();
            } catch (PDOException $e) {
                return "error :" . $e->getMessage();
            }
        }else{
            $containId = $contain->getId();
            $quantityBefore = intval($contain->getQuantity());
            $someQuantity = $quantityBefore + $quantity;
            $changed = $this->changeQuantityOfContain($containId, intval($someQuantity));
            if ($changed == true){
                return 1;
            }
        }
    }

    public function deleteContain($containId){
        $pdo = $this->db->getPDO();
        //prepare
        $sql = "UPDATE contain SET  contain.trash = 1 WHERE contain.id = :containId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "containId" => $containId
        ]);
    }

    public function changeQuantityOfContain($containId, $quantity){
        $pdo = $this->db->getPDO();
        //prepare
        try {
            $sql = "UPDATE contain SET  contain.quantity = :quantity WHERE contain.id = :containId";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "quantity" => $quantity,
                "containId" => $containId
            ]);
            return true;
        }catch (PDOException $e){
            return $e;
        }
    }

    public function getContainsForCart($cartId)
    {
        $pdo = $this->db->getPDO();
        $sql= "SELECT * FROM contain  WHERE contain.cart_id = :cartId and contain.trash = 0";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "cartId" => $cartId
        ]);
        $contains = [];
        while ($contain = $stmt->fetchObject("App\Classes\Contain")) {
            $contains[] = $contain->jsonify();
        }
        return $contains;
    }

}
