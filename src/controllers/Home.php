<?php
namespace App\Controllers;

use App\Classes\Controller;

class Home  {
  /**
   * Retourne la home page
   */
  public function index() {
    include '../src/views/home/home.php';
  }
}