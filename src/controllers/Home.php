<?php

include '../src/classes/Controller.php';
use App\Classes\Controller;

class Home extends Controller {
  /**
   * Retourne la home page
   */
  public function index() {
    include '../src/views/home/home.php';
  }
}