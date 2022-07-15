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
        var_dump($id);
        $quantity = explode('=', $_SERVER['REQUEST_URI'])[2];
        var_dump($quantity);
        $verif = $containModel->verifyCartUserByContainId($id);
        if ($verif === false) {
            $errorMsg = 'Vous n\'etes pas autorisés à modifier le panier de quelqu\'un d\'autre.';
            header('Location: /checkout', true, 999);
            // A REMPLACER PAR DES HEADERS !!
        }
        $containModel->changeQuantityOfContain($id, $quantity);
        header('Location: /checkout');
    }

    public function deleteContain()
    {
        $containModel = new ContainModel();
        $id = explode('=', $_SERVER['REQUEST_URI'])[1];
        $id = explode('&', $id)[0];
        var_dump($id);
        $verif = $containModel->verifyCartUserByContainId($id);
        if ($verif === false) {
            $errorMsg = 'Vous n\'etes pas autorisés à modifier le panier de quelqu\'un d\'autre.';
            header('Location: /checkout', true, 999);
            // A REMPLACER PAR DES HEADERS !!
        }
        $containModel->deleteContain($id);
        header('Location: /checkout');
    }
}