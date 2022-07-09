<?php
namespace App\Controllers;

use App\Classes\Controller;
use App\Models\StoreModel;

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

  // PARTIE ANTOINE
  // PAGES
  public function store()
  {
    $storeModel = new StoreModel();
    $stores = $storeModel->getAllStores();
    $_SESSION['stores'] = $stores;
    include '../src/views/CRUDs/ant_crud_store/store.php';
  }

  public function addStore()
  {
    include '../src/views/CRUDs/ant_crud_store/addStore.php';
  }

  public function updateStore()
  {
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
}