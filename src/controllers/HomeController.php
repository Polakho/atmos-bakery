<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Controllers\FrontController;
use App\Models\ProductModel;

class HomeController extends Controller
{

  public function __construct()
  {
    $this->frontController = new FrontController();
    $this->productModel = new ProductModel();
  }

  /**
   * Retourne la home page
   */
  public function index()
  {
      $products = $this->productModel->getThreeRandomProduct();
      include '../src/views/home/home.php';
  }
}
