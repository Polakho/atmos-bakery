<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\ProductModel;
use App\Models\ScheduleModel;
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

    private function params()
    {
        return (json_decode(file_get_contents('php://input'), true));
    }

  // PARTIE ANTOINE
  // PAGES
  public function store()
  {
    $storeModel = new StoreModel();
    $stores = $storeModel->getAllStores();
    // return $stores;
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


  // PARTIE LEANDRE
  public function products()
  {
    $productModel = new ProductModel();
    $products = $productModel->getAllProduct();
    // return $stores;
    include '../src/views/CRUDs/products/products.php';
  }
}

// PARTIE ALEX LE GROS BG

public function schedule()
{
    $storeModel = new StoreModel();
    $stores = $storeModel->getAllStores();
    $scheduleModel = new ScheduleModel();
    // return $stores;
    include '../src/views/CRUDs/alex_crud_schedule/schedule.php';
}

public function updateSchedule()
{
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];

    $storeModel = new StoreModel();
    $store = $storeModel->getStoreById($id);

    $scheduleModel = new ScheduleModel();
    $schedules = $scheduleModel->getSchedulesByStoreId($id);

    include '../src/views/CRUDs/alex_crud_schedule/updateSchedule.php';
}

public function updatingSchedules()
{
    $params = $this->params();

    $session = $params["session"];
    if (isset($session['user']) && $session['user']['roles'] === 'ADMIN') {

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $semaine = $params['semaine'];

        $storeId = $params['storeId'];

        $scheduleModel = new scheduleModel();

        $scheduleModel->updateSchedules($semaine, $storeId);
        exit();
    } else {
        echo json_encode('Vous n\'avez pas les droits nécessaires pour effectuer cette action.');
    }
}

public function addSchedule()
{

    $id = explode('=', $_SERVER['REQUEST_URI'])[1];

    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN' && isset($id)) {
        $scheduleModel = new ScheduleModel();
        $scheduleModel->createScheduleForStore($id);
        header('Location: /admin/updateSchedule?updateid='. $id);
    } else {
        echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
}

public function deleteSchedule()
{

    $id = explode('=', $_SERVER['REQUEST_URI'])[1];

    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN' && isset($id)) {
        $scheduleModel = new ScheduleModel();
        $scheduleModel->deleteScheduleForStore($id);
        header('Location: /admin/schedule');
    } else {
        echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
}
// FIN PARTIE ALEX LE GROS BG
}
