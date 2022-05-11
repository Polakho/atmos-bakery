<?php

// include '../src/classes/Autoloader.php';
include '../src/classes/Controller.php';
use App\Classes\Controller;

class About extends Controller {
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