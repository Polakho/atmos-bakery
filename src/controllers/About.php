<?php
 namespace App\Controllers;

use App\Classes\Controller;

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
    echo "la page about";
    include '../src/views/about/about.php';
  }
}