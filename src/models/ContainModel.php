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

    public function getContainByProductAndCart($productId, $cartId)
    {
        if (!empty($productId) && !empty($cartId)) {
            try {
                $pdo = $this->db->getPDO();
                $stmt = $pdo->prepare("SELECT * FROM contain WHERE product_id = :productId and cart_id = :cartId and trash = 0");
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

    public function ajouterContain($quantity, $productId, $cartId)
    {
        $pdo = $this->db->getPDO();
        $contain = $this->getContainByProductAndCart($productId, $cartId);
        $quantityToUse = intval($quantity);
        if ($contain == null) {
            try {
                //Update trash  0
                $sql = "INSERT INTO  contain (quantity, trash, product_id, cart_id) VALUES (:quantity, 0, :productId, :cartId)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    "quantity" => $quantityToUse,
                    "productId" => $productId,
                    "cartId" => $cartId
                ]);

                return $pdo->lastInsertId();
            } catch (PDOException $e) {
                return "error :" . $e->getMessage();
            }
        } else {
            $containId = $contain->getId();
            $quantityBefore = intval($contain->getQuantity());
            $someQuantity = $quantityBefore + $quantityToUse;
            $changed = $this->changeQuantityOfContain($containId, intval($someQuantity));
            if ($changed == true) {
                return 1;
            }
        }
    }

    public function deleteContain($cartId, $containId)
    {
        try {
            $pdo = $this->db->getPDO();
            //prepare
            $sql = "UPDATE contain SET  contain.trash = 1 WHERE contain.product_id = :containId AND contain.cart_id = :cartId";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "containId" => $containId,
                "cartId" => $cartId
            ]);
            return true;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function changeQuantityOfContain($containId, $quantity)
    {
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
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function getContainsForCart($cartId)
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT * FROM contain  WHERE contain.cart_id = :cartId and contain.trash = 0";

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

    public function verifyCartUserByContainId($containId) // Verifie que l'utilisateur connecté agit bien avec son panier
    {
        $userId = $_SESSION['user']['id'];
        $pdo = $this->db->getPDO();
        $sql = "SELECT cart_id FROM contain  WHERE contain.id = :containId and contain.trash = 0";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "containId" => $containId
        ]);
        $row = $stmt->fetch();
        if (isset($row[0])) {
            $cartId = $row[0];
            $sql = "SELECT user_id FROM cart  WHERE id = :cartId ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "cartId" => $cartId
            ]);
            $row = $stmt->fetch();
            if (isset($row[0])) {
                $fetchedUserId = $row[0];
            }
            if ($fetchedUserId === $userId) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
