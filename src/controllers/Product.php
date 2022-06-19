<?php
 namespace App\Controllers;

use App\Classes\Controller;
use App\Controllers\FrontController;
use App\Models\CartModel;
use App\Models\ContainModel;
use App\Models\ProductModel;


class Product
{
    /**
     * @var ProductModel
     */
    private $productModel;

    public function __construct(){
        $this->productModel = new ProductModel();
        $this->frontController = new FrontController();
        $this->containModel = new ContainModel;
        $this->cartModel = new CartModel;
    }

    public function index() {

        $products = $this->productModel->getAllProduct();
        $perPage = 6;
        $count = count($products);
        $pages = ceil($count/$perPage);
        $list = array_chunk($products, $perPage);
        include '../src/views/product/list.php';
    }
}
