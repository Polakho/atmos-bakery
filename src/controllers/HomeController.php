<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Controllers\FrontController;

class HomeController extends Controller
{

  public function __construct()
  {
    $this->frontController = new FrontController();
  }

  /**
   * Retourne la home page
   */
  public function index()
  {
    include '../src/views/home/home.php';
  }
}
