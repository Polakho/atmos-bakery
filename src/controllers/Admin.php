<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\ProductModel;
use App\Models\ScheduleModel;
use App\Models\StoreModel;
use App\Models\UserModel;
use Dotenv\Dotenv;


class Admin extends Controller
{
  public function __construct()
  {
    $this->frontController = new FrontController();
    $this->dotenv  = Dotenv::createImmutable(__DIR__ . "/../../");
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

  private function params()
  {
    return (json_decode(file_get_contents('php://input'), true));
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
    // echo $id;
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
      if (isset($_POST['image'])) {
        $file = $_POST['image'];
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
      $storeModel->updateStore($id, $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['description']);
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
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN' && isset($id) && isset($_POST['image'])) {
      $store = new StoreModel();
      $img = $_POST['image'];
      $store->updateImage($id, $img);
      header('Location: /admin/store');
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
  }

  // FIN PARTIE ANTOINE

  //DEBUT PARTIE TRISTAN
  //Pages
  public function users()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    $userModel = new UserModel();
    $users = $userModel->getAllUsers();
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
    include '../src/views/CRUDs/trist_crud_users/newUser.php';
  }


  public function updateuser()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    $userModel = new UserModel();
    $user = $userModel->getUsersById($id); //J'ai commenté cette ligne pr pvr test la partie products
    // return $user;
    include '../src/views/CRUDs/trist_crud_users/updateUser.php';
  }
  //METHODE
  public function deleteUser()
  {
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN' && isset($id)) {
      $user = new UserModel();
      $user->deleteUser($id);
      header('Location: /admin/users');
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
  }
  public function trashUser()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
  <?php
    $userModel = new UserModel();
    $users = $userModel->getAllUsers();
    // return $users;
    include '../src/views/CRUDs/trist_crud_users/users.php';
  }

  public function updatingUser()
  {
    $userModel = new UserModel();
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN') {
      $userModel->updateUser($id, $_POST['mail'], $_POST['name'], $_POST['f_name'], $_POST['trash'], $_POST['roles']);
      header('Location: /admin/users');
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
  }

  public function createUser()
  {
    $userModel = new UserModel();
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN') {
      $userModel->createUser($_POST['name'], $_POST['f_name'], $_POST['mail'], $_POST['password'], $_POST['roles']);
      header('Location: /admin/users');
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
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

  public function addProduct()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php
      $productModel = new ProductModel();
      include './css/global.css'; ?>
    </style>
  <?php
    include '../src/views/CRUDs/ld_crud_products/addProduct.php';
  }


  public function updateProduct()
  {
  ?>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
      <?php include './css/global.css'; ?>
    </style>
<?php
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    $productModel = new ProductModel();
    $product = $productModel->arrayGetProductById($id);
    include '../src/views/CRUDs/ld_crud_products/updateProduct.php';
  }

  public function deleteProduct()
  {
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN' && isset($id)) {
      $product = new ProductModel();
      $verif = $product->deleteProductById($id);
      if ($verif === true) {
        // header('Location: /admin/products?status=success');
      } else {
        // header('Location: /admin/products?status=failed');
      }
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
    }
  }

  // METHODS
  public function addingProduct()
  {
    $productModel = new ProductModel();
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['category'])) {
      //$name, $price, $categoryId, $description = '', $compo = '', $image = '', $weight = ''
      $newProductId = $productModel->addProduct($_POST['name'], $_POST['price'], $_POST['category'], $_POST['description'], $_POST['compo'], $_POST['image'], $_POST['weight']);
      if ($newProductId !== 0) {
        header('Location: /admin/products?status=success');
      } else {
        header('Location: /admin/products?status=failed');
      }
    } else {
      $errorMsg = "Veuillez remplir tous les champs.";
      header('Location: /admin/addProduct');
    }
  }

  public function updatingProduct()
  {
    $productModel = new ProductModel();
    $id = explode('=', $_SERVER['REQUEST_URI'])[1];
    if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN') {
      //$id, $name, $price, $categoryId, $image, $description, $compo = '', $weight = 0
      $check = $productModel->updateProduct($id, $_POST['name'], $_POST['price'], $_POST['category'], $_POST['image'], $_POST['description'], $_POST['compo'], $_POST['weight']);
      if ($check === true) {
        header('Location: /admin/products?status=success');
      } else {
        header('Location: /admin/products?status=failed');
      }
    } else {
      echo 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.';
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
      header('Location: /admin/updateSchedule?updateid=' . $id);
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
