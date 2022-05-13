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

    public function ajouterContain($quantity, $userId, $cartId){
        $pdo = $this->db->getPDO();
        $sql = "INSERT INTO  contain (quantity, trash, product_id, cart_id) VALUES (:quantity, 0, :productId, :cartId)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "quantity" => $quantity,
            "userId" => $userId,
            "cartId" => $cartId
        ]);

        return $pdo->lastInsertId();
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
        $sql = "UPDATE contain SET  contain.quantity = :quantity WHERE contain.id = :containId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "quantity" => $quantity,
            "containId" => $containId
        ]);
    }
}
