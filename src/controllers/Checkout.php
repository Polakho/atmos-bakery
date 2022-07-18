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
        $this->containModel = new ContainModel();
        $this->productModel = new ProductModel();
        $this->frontController = new FrontController();
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            $cart = $this->cartModel->getActiveCartForUser($_SESSION['user']['id']);
            $contains = $this->containModel->getContainsForCart($cart->getId());
            if (isset(explode('=', $_SERVER['REQUEST_URI'])[1])) {
                $status = explode('=', $_SERVER['REQUEST_URI'])[1];
            }
            include '../src/views/checkout/checkout.php';
        } else {
            $errorMsg = "Log in first, checkout later... ;)";
            include '../src/views/login/login.php';
        }
    }

    // PARTIE LEANDRE: CHECKOUT
    public function updateContain()
    {
        $containModel = new ContainModel();
        $id = explode('=', $_SERVER['REQUEST_URI'])[1];
        $id = explode('&', $id)[0];
        $quantity = explode('=', $_SERVER['REQUEST_URI'])[2];
        $verif = $containModel->verifyCartUserByContainId($id);
        if ($verif === false) {
            header('Location: /checkout?status=unauthorized'); //response code 401 pour dire que l'accès n'est pas autorisé (vu que header et pas de include, obligé de passer par ca) 
        } else {
            $containModel->changeQuantityOfContain($id, $quantity);
            header('Location: /checkout');
        }
    }

    public function deleteContain()
    {
        $containModel = new ContainModel();
        $id = explode('=', $_SERVER['REQUEST_URI'])[1];
        $id = explode('&', $id)[0];
        $verif = $containModel->verifyCartUserByContainId($id);
        if ($verif === false) {
            header('Location: /checkout?status=unauthorized'); //response code 401 pour dire que l'accès n'est pas autorisé (vu que header et pas de include, obligé de passer par ca) 
        } else {
            $containModel->deleteContain($id);
            header('Location: /checkout');
        }
    }
}
