<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Controllers\FrontController;
use App\Models\CartModel;
use App\Models\ContainModel;
use App\Models\ProductModel;
use Stripe\StripeClient;

class Payment extends Controller
{

    /**
     * @var CartModel
     */
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->containModel = new ContainModel();
        $this->productModel = new ProductModel();
        $this->frontController = new FrontController();
    }

    public function index()
    {

        if (isset($_SESSION['user'])) {
            $cart = $this->cartModel->getActiveCartForUser($_SESSION['user']['id']);
            $contains = $this->containModel->getContainsForCart($cart->getId());

            include '../src/views/payment/payment.php';
        } else {
            $errorMsg = "Log in first, checkout later... ;)";
            include '../src/views/login/login.php';
        }
    }
}
