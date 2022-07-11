<?php

namespace App\Models;

use App\Classes\Autoloader;
use App\Classes\Database;
use PDOException;

Autoloader::register();

class StoreModel 
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getAllStores()
  {
    $pdo = $this->db->getPDO();
    $sql = "SELECT * FROM store";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stores = $stmt->fetchAll();
    foreach ($stores as $key => $store) {
      $stores[$key]['image'] = $this->getImage($store['id']);
    }
    return $stores;
  }

  public function getStoreById($id)
  {
    $pdo = $this->db->getPDO();
    $sql = "SELECT * FROM store WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "id" => $id
    ]);
    $store = $stmt->fetch();
    $rs = $this->getImageBase64($id);
    if ($rs) {
      $store['image'] = $rs;
    }
    // $store['image'] = $this->getImage($store['id']);
    return $store;
  }

  public function addStore($name, $phone, $address, $description)
  {
    $pdo = $this->db->getPDO();
    $sql = "INSERT INTO store(name, phone, address, description) VALUES (:name, :phone, :address, :description)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "name" => $name,
      "phone" => $phone,
      "address" => $address,
      "description" => $description,
    ]);
    $newStoreId = $pdo->lastInsertId();
    return $newStoreId;
  }

  public function deleteStore($id)
  {
    $pdo = $this->db->getPDO();
    $sql = "DELETE FROM store WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "id" => $id,
    ]);
  }

  public function updateStore($id, $name, $phone, $address, $description)
  {
    $pdo = $this->db->getPDO();
    $sql = "UPDATE store SET name = :name, phone = :phone, address = :address, description = :description WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "id" => $id,
      "name" => $name,
      "phone" => $phone,
      "address" => $address,
      "description" => $description,
    ]);
  }

  public function addImage($id, $image)
  {
    $test = $this->isThereAnImageForStore($id);
    if (!$test) {
      $pdo = $this->db->getPDO();
      $sql = "INSERT INTO store_picture(image, store_id) VALUES (:image, :store_id)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        "image" => $image,
        "store_id" => $id,
      ]);
    } else {
      $this->desactivateImageForStore($id);
      $pdo = $this->db->getPDO();
      $sql = "INSERT INTO store_picture(image, store_id) VALUES (:image, :store_id)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        "image" => $image,
        "store_id" => $id,
      ]);
    }
  }

  public function isThereAnImageForStore($id)
  {
    $pdo = $this->db->getPDO();
    $sql = "SELECT * FROM store_picture WHERE store_id = :store_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "store_id" => $id,
    ]);
    $result = $stmt->fetch();
    return $result;
  }

  public function desactivateImageForStore($id)
  {
    $pdo = $this->db->getPDO();
    $sql = "UPDATE store_picture SET actif = 0 WHERE store_id = :store_id AND actif = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "store_id" => $id,
    ]);
  }

  public function getImage($id)
  {
    $pdo = $this->db->getPDO();
    $sql = "SELECT image FROM store_picture WHERE store_id = :store_id AND actif = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "store_id" => $id,
    ]);
    $images = $stmt->fetchAll();
    return $images;
  }

  // fetch a base 64 image from the database
  public function getImageBase64($id)
  {
    $pdo = $this->db->getPDO();
    $sql = "SELECT image FROM store_picture WHERE store_id = :store_id AND actif = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      "store_id" => $id,
    ]);
    $images = $stmt->fetchAll();
    $image = $images[0]['image'];
    $image = base64_encode($image);
    return $image;
  }

  public function updateImage($id, $image)
  {
    $result = $this->isThereAnImageForStore($id);
    if ($result) {
      $this->desactivateImageForStore($id);
      $pdo = $this->db->getPDO();
      $sql = "INSERT INTO store_picture(image, store_id) VALUES (:image, :store_id)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        "image" => $image,
        "store_id" => $id,
      ]);
    } else {
      $pdo = $this->db->getPDO();
      $sql = "INSERT INTO store_picture(image, store_id) VALUES (:image, :store_id)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        "image" => $image,
        "store_id" => $id,
      ]);
    }
  }
}