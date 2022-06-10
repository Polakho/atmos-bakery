<?php
 namespace App\Controllers;

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