<?php
 namespace App\Controllers;

use App\Classes\Controller;
use App\Models\StoreModel;

class About extends Controller {

    public function __construct(){
        $this->frontController = new FrontController();
    }
  /**
   * Cette méthode renvoie la page About
   * 
   * @return void
   */
  public function index() {
    // echo "la page about";
    $stores = $this->listStores();
    include '../src/views/about/about.php';
  }

  private function listStores()
  {
    $storeModel = new StoreModel();
    $stores = $storeModel->getAllStores();
    return $stores;
  }

  public function formatPhone($phone)
  {
    $re = '/[0-9]{2}/';
    preg_match_all($re, $phone, $matches, PREG_SET_ORDER, 0);

    $formatted = $matches[0][0]." ".$matches[1][0]." ".$matches[2][0]." ".$matches[3][0]." ".$matches[4][0];
    return $formatted;
  }
}