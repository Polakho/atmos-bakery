<?php
 namespace App\Controllers;

use App\Models\ProductModel;


class Product
{
    /**
     * @var ProductModel
     */
    private $productModel;

    public function __construct(){
        $this->productModel = new ProductModel();
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
