<?php
namespace App\Controllers;

// On appelle le modèle et le contrôleur principaux

use App\Controllers\HomeController;

$params = explode('/', $_GET['p']);
if ($params[0] != '') {
  // Stockage des variables controller et action (controller et methode)
  $controller = ucfirst($params[0]);

  //Acces pour l'api créer par Swagger
  if($controller == "Swagger"){
      require_once "../public/swagger/swagger.json";
      exit();
  }

  $action = isset($params[1]) ? $params[1] : 'index';
  // Appel controller
  require_once('../src/controllers/'.$controller.'.php');
  // Instancie le controller
  $className= "App\\Controllers\\$controller";

  $controller = new $className();

  if (method_exists($controller, $action)) {
    // Appel de la methode
    $controller->$action();
  } else {
    http_response_code(404);
    echo "La page recherchée n'existe pas";
  }
} else {

    $controller = new HomeController();
  $controller->index();
}

// $oldrouter = substr(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), 1);

// switch ($oldrouter) {
//   case 'about':
//     require "../src/controllers/about.controller.php";
//     break;
//   case 'register':
//     require "../src/controllers/register.controller.php";
//     break;
//   case 'auth':
//     require "../src/controllers/auth.controller.php";
//     break;

//   default:
//     require "../src/controllers/home.controller.php";
//     break;
// }