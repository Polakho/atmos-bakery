<?php
namespace App\Controllers;

use App\Classes\Controller;
use App\Models\CartModel;

class FrontController extends Controller
{

    /**
     * @var CartModel
     */
    private $cartModel;

    public function __construct(){
        $this->cartModel = new CartModel();
    }

     public function header(){
        if (isset($_SESSION['userId'])) {
            $cart = $this->cartModel->getActiveCartForUser($_SESSION['userId']);
        }

        include __DIR__.'/../components/header/header.php';
    }

    public function footer(){
        include __DIR__.'/../components/footer/footer.php';
    }
}