<?php

use App\Classes\Controller;
use App\Models\ProductModel;


class Product extends Controller
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

        include '../src/views/product/list.php';
    }
}
