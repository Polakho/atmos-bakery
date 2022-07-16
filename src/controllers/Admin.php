<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\ProductModel;
use App\Models\StoreModel;
use App\Models\UserModel;

class Admin extends Controller
{
  public function __construct()
  {
    $this->frontController = new FrontController();
  }

  public function index()
  {
?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    include '../src/views/CRUDs/index.php';
  }

  // PARTIE ANTOINE
  // PAGES
  public function store()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    $storeModel = new StoreModel();
    $stores = $storeModel->getAllStores();
    // return $stores;
    include '../src/views/CRUDs/ant_crud_store/store.php';
  }

  public function addStore()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    include '../src/views/CRUDs/ant_crud_store/addStore.php';
  }

  public function updateStore()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    echo $id;
    $storeModel = new StoreModel();
    $store = $storeModel->getStoreById($id);
    // var_dump($store);
    include '../src/views/CRUDs/ant_crud_store/updateStore.php';
  }

  // METHODS
  public function addingStore()
  {
    $storeModel = new StoreModel();
    if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['description'])) {
      $newStoreId = $storeModel->addStore($_POST['name'], $_POST['phone'], $_POST['address'], $_POST['description']);
      if (isset($_FILES['image'])) {
        $file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $storeModel->addImage($newStoreId, $file);
      }
      header('Location: /admin/store');
    } else {
      $errorMsg = "Veuillez remplir tous les champs.";
      header('Location: /admin/addStore');
    }
  }

  public function updatingStore()
  {
    $storeModel = new StoreModel();
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN') {
      $storeModel->updateStore($id, $_POST['name'], $_POST['address'], $_POST['phone'], $_POST['description']);
      header('Location: /admin/store');
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
  }

  public function deleteStore()
  {
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN' && isset($id)) {
      $store = new StoreModel();
      $store->deleteStore($id);
      $store->desactivateImageForStore($id);
      header('Location: /admin/store');
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
  }

  public function updatingImage()
  {
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN' && isset($id) && isset($_FILES['image'])) {
      $store = new StoreModel();
      $img = addslashes(file_get_contents($_FILES['image']['tmp_name']));
      $store->updateImage($id, $img);
      header('Location: /admin/store');
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
  }

  // FIN PARTIE ANTOINE

  //DEBUT PARTIE TRISTAN
  //Pages
  public function user()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    $userModel = new UserModel();
    $users = $userModel->getAllUser();
    // return $users;
    include '../src/views/CRUDs/trist_crud_users/users.php';
  }
  public function newuser()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    include '../src/views/CRUDs/trist_crud_newUser';
  }
  public function updateuser()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    $userModel = new UserModel();
    // $users = $userModel->get(); //J'ai commenté cette ligne pr pvr test la partie products
    // return $users;
    include '../src/views/CRUDs/trist_crud_users';
  }



  //PARTIE LEANDRE
  public function products()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
<?php
    $productModel = new ProductModel();
    $products = $productModel->getAllProductJson();
    include '../src/views/CRUDs/ld_crud_products/products.php';
  }
}
