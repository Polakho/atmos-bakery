<?php

namespace App\Models;

use App\Classes\Autoloader;
use App\Classes\Product;
use App\Classes\Database;
use Stripe\StripeClient;
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

                $stripe = new \Stripe\StripeClient("sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU");
                try {
                    $stripe->products->create([
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'description' => $product->getDescription(),
                        'images' => [$product->getImage()],
                        'metadata' => [
                            'compo' => $product->getCompo(),
                            'weight' => $product->getWeight(),
                            'category_id' => $product->getCategoryId()
                        ]
                    ]);

                    $stripe->prices->create([
                        'unit_amount_decimal' => $product->getPrice() * 100,
                        'currency' => 'eur',
                        'product' => $product->getId(),
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
}
