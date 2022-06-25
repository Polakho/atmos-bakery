<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Controllers\FrontController;
use App\Models\CartModel;
use App\Models\ContainModel;
use App\Models\ProductModel;

class Checkout extends Controller
{

    /**
     * @var CartModel
     */
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->frontController = new FrontController();
    }

    public function index()
    {
        if (isset($_SESSION['userId'])) {
            $cart = $this->cartModel->getActiveCartForUser($_SESSION['userId']);
            include '../src/views/checkout/checkout.php';
        } else {
            $errorMsg = "Log in first, checkout later... ;)";
            include '../src/views/login/login.php';
        }
    }
}
