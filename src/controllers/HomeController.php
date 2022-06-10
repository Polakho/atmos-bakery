<?php
namespace App\Controllers;

use App\Classes\Controller;

class HomeController extends Controller {

    public function __construct(){

    }

  /**
   * Retourne la home page
   */
  public function index() {
    include '../src/views/home/home.php';
  }
}