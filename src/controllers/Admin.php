<?php
namespace App\Controllers;

use App\Classes\Controller;

class Admin extends Controller
{
  public function __construct()
  {
    $this->frontController = new FrontController();
  }

  public function index()
  {
    include '../src/views/CRUDs/index.php';
  }

  public function store()
  {
    include '../src/views/CRUDs/ant_crud_store/store.php';
  }
}