<?php

namespace App\Models;

use App\Classes\Autoloader;
use App\Classes\Product;
use App\Classes\Database;
use \Stripe\StripeClient;
use PDOException;

Autoloader::register();

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param $id
     * @return Product|null
     */
    public function getProductById($id)
    {

        if (!empty($id)) {
            try {
                $pdo = $this->db->getPDO();
                $stmt = $pdo->query("SELECT * FROM product WHERE id = $id");
                return $stmt->fetchObject('App\Classes\Product');
            } catch (PDOException $e) {
                echo  "error :" . $e->getMessage();
            }
        }
        return null;
    }

    public function saveProduct(Product $product)
    {
        $pdo = $this->db->getPDO();
        $object = (array)$product;
        $id = $product->getId();
        if ($id === null || $id <= 0) {
            try {
                $sql = "INSERT INTO product(name, price, description, compo, trash, image, weight, category_id) VALUES (:name, :price, :description, :compo, :trash, :image, :weight, :category_id)";
                $stmt = $pdo->prepare($sql);

                if ($product->isTrash() === false) {
                    $trash = 0;
                } else {
                    $trash = 1;
                }

                $response = $stmt->execute([
                    "name" => $product->getName(),
                    "price" => $product->getPrice(),
                    "description" => $product->getDescription(),
                    "compo" => $product->getCompo(),
                    "trash" => $trash,
                    "image" => $product->getImage(),
                    "weight" => $product->getWeight(),
                    "category_id" => $product->getCategoryId(),
                ]);
            } catch (PDOException $e) {

                echo  "error :" . $e->getMessage();
            }
        }
        $data = (array)$this->getProductById($id);

        $difference = array_diff_assoc($object, $data);
        foreach ($difference as $key => $value) {
            $forTableKey = str_replace(" App\Classes\Product ", "", $key);
            $statement = "UPDATE product SET  $forTableKey = '$value' WHERE id = $id";
            $this->db->execute($statement);
        }
    }

    public function deleteProduct(Product $product)
    {
        $product->setTrash(1);
        $this->saveProduct($product);
    }

    public function getAllProduct($storeId = null)
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT * FROM product LEFT JOIN store_product_relation as s ON product.id = s.product_id  WHERE product.trash = 0 AND s.store_id = $storeId";
        if ($storeId == null) {
            $sql = "SELECT * FROM product WHERE product.trash = 0";
        }
        $stmt = $pdo->query($sql);
        $products = [];
        while ($product = $stmt->fetchObject("App\Classes\Product")) {
            $products[] = $product;
        }
        return $products;
    }

    public function getThreeRandomProduct()
    {
        $products = $this->getAllProduct();
        $array = [];
        $ids = array_rand($products, 3);
        foreach ($ids as $id) {
            $array[] = $products[$id];
        }
        return $array;
    }

    public function getAllProductJson($storeId = null)
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT * FROM product LEFT JOIN store_product_relation as s ON product.id = s.product_id  WHERE product.trash = 0 AND s.store_id = $storeId";
        if ($storeId == null) {
            $sql = "SELECT * FROM product WHERE product.trash = 0";
        }
        $stmt = $pdo->query($sql);
        $products = [];
        while ($product = $stmt->fetchObject("App\Classes\Product")) {
            $products[] = $product->jsonify();
        }
        return $products;
    }

    public function addProduct($name, $price, $categoryId, $description = '', $compo = '', $image = '', $weight = '')
    {
        $pdo = $this->db->getPDO();
        $sql = "INSERT INTO product(name, price, category_id, description, compo, image, weight) VALUES (:name, :price, :category_id, :description, :compo, :image, :weight) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "name" => $name,
            "price" => $price,
            "category_id" => $categoryId,
            "description" => $description,
            "compo" => $compo,
            "image" => $image,
            "weight" => $weight,
        ]);
        $newProductId = $pdo->lastInsertId();
        $stripe = new \Stripe\StripeClient("sk_test_51LMubWEwkB3AlPNOHdSWpQtXjSuqPCZHdxL0dKhMeavcVV4b7VMJfvFJzMsOkSwojslHH55BbQFZAPHXNJ1yfnID00mquLbGul");
        try {
            $stripe->products->create([
                "id" => $newProductId,
                'name' => $name,
                'description' => $description,
                'images' => [$image],
                'metadata' => [
                    'compo' => $compo,
                    'weight' => $weight,
                    'category_id' => $categoryId
                ]
            ]);

            $stripe->prices->create([
                'unit_amount_decimal' => $price * 100,
                'currency' => 'eur',
                'product' => $newProductId,
                'metadata' => ['price_value' => $price]

            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            echo 'Status is:' . $e->getHttpStatus() . '\n';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
        } catch (\Stripe\Exception\RateLimitException $e) {
            echo 'RateLimitException';
            // Too many requests made to the API too quickly
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            echo 'InvalidRequestException:';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
            // continue;
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Exception\AuthenticationException $e) {
            echo 'AuthenticationException';
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            echo 'ApiConnectionException';
            // Network communication with Stripe failed
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo 'ApiErrorException';
            // Display a very generic error to the user, and maybe send
            // yourself an email
        }
        return $newProductId;
    }

    // public function getCategNameByCategId($categoryId) //
    // {
    //     $pdo = $this->db->getPDO();
    //     $sql = "SELECT name FROM category WHERE category_id = :categoryId ";
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->execute([
    //         "categoryId" => $categoryId,

    //     ]);
    //     $result = $stmt->fetch();
    //     return $result[0];
    // }

    public function getCategories() //
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT name FROM category";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $categoryList = [];
        $categories = $stmt->fetchAll();
        foreach ($categories as $key => $category) {
            $categoryList += [$key + 1 => $category[0]];
        }
        return $categoryList;
    }

    public function listCategories()
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT name, category_id FROM category";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll();
        return $categories;
    }

    public function arrayGetProductById($id)
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $product = $stmt->fetch();
        return $product;
    }

    public function updateProduct($id, $name, $price, $categoryId, $image, $description, $compo = '', $weight = 0)
    {
        try {
            $pdo = $this->db->getPDO();
            $sql = "SELECT price FROM product WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "id" => $id,
            ]);
            $result = $stmt->fetch();
            $updatePrice = false;
            if ($price !== $result[0]) {
                $updatePrice = true;
            }
            $pdo = $this->db->getPDO();
            $sql = "UPDATE product SET name = :name, price = :price, category_id = :category_id, image = :image, description = :description, compo = :compo, weight = :weight WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "id" => $id,
                "name" => $name,
                "price" => $price,
                "category_id" => $categoryId,
                "image" => $image,
                "description" => $description,
                "compo" => $compo,
                "weight" => $weight
            ]);

            $stripe = new \Stripe\StripeClient(
                'sk_test_51LMubWEwkB3AlPNOHdSWpQtXjSuqPCZHdxL0dKhMeavcVV4b7VMJfvFJzMsOkSwojslHH55BbQFZAPHXNJ1yfnID00mquLbGul'
            );
            $product = $stripe->products->update(
                $id,
                [
                    'name' => $name,
                    'description' => $description,
                    'images' => [$image],
                    'metadata' => [
                        'price' => $price,
                        'compo' => $compo,
                        'weight' => $weight,
                        'category_id' => $categoryId
                    ]
                ]
            );
            if ($updatePrice === true) {
                $stripePrice = $stripe->prices->search([
                    'query' => "product:'" . $id . "'",
                ]);
                $stripeDisabledPrice = $stripe->prices->search([
                    'query' => "active: 'false' AND product:'" . $id . "' AND metadata['price_value']: '" . $price . "'",
                ]);
                // var_dump($stripeDisabledPrice['data']);
                if (isset($stripeDisabledPrice) and isset($stripeDisabledPrice['data'][0])) {
                    $stripe->prices->update(
                        $stripeDisabledPrice['data'][0]['id'],
                        [
                            'active' => 'true'
                        ]
                    );
                    $stripe->prices->update(
                        $stripePrice['data'][0]['id'],
                        [
                            'active' => 'false'
                        ]
                    );
                } else {
                    $stripe->prices->update(
                        $stripePrice['data'][0]['id'],
                        [
                            'active' => 'false'
                        ]
                    );

                    $stripe->prices->create([
                        'unit_amount_decimal' => $price * 100,
                        'currency' => 'eur',
                        'product' => $id,
                        'metadata' => ['price_value' => $price]
                    ]);
                }
            }

            return true;
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            echo 'Status is:' . $e->getHttpStatus() . '\n';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
        } catch (\Stripe\Exception\RateLimitException $e) {
            echo 'RateLimitException';
            // Too many requests made to the API too quickly
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            echo 'InvalidRequestException:';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
            // continue;
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Exception\AuthenticationException $e) {
            echo 'AuthenticationException';
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            echo 'ApiConnectionException';
            // Network communication with Stripe failed
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo 'ApiErrorException';
            // Display a very generic error to the user, and maybe send
            // yourself an email
        }
    }


    public function deleteProductById($id) // Implémentation de stripe --> la bdd sera toujours à jours sauf si modifiée en cash
    {
        try {
            //Mise a jour des contains, sans ça les contains restent dans le panier alors qu'ils ne sont plus lié à aucun produit
            $pdo = $this->db->getPDO();
            $sql = "UPDATE contain SET trash = 1 WHERE product_id = :id ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "id" => $id,
            ]);

            //UPDATE PRODUCT
            $pdo = $this->db->getPDO();
            $sql = "UPDATE product SET trash = 1 WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "id" => $id,
            ]);

            $stripe = new \Stripe\StripeClient(
                'sk_test_51LMubWEwkB3AlPNOHdSWpQtXjSuqPCZHdxL0dKhMeavcVV4b7VMJfvFJzMsOkSwojslHH55BbQFZAPHXNJ1yfnID00mquLbGul'
            );

            $product = $stripe->products->update(
                $id,
                [
                    'active' => 'false'
                ]
            );

            $stripePrice = $stripe->prices->search([
                'query' => "product:'" . $id . "'",
            ]);
            // var_dump($stripePrice['data'][0]);
            $stripe->prices->update(
                $stripePrice['data'][0]['id'],
                [
                    'active' => 'false'
                ]
            );




            return true;
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            echo 'Status is:' . $e->getHttpStatus() . '\n';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
        } catch (\Stripe\Exception\RateLimitException $e) {
            echo 'RateLimitException';
            // Too many requests made to the API too quickly
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            echo 'InvalidRequestException:';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
            // continue;
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Exception\AuthenticationException $e) {
            echo 'AuthenticationException';
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            echo 'ApiConnectionException';
            // Network communication with Stripe failed
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo 'ApiErrorException';
            // Display a very generic error to the user, and maybe send
            // yourself an email
        }
    }
}
