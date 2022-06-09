<?php

use App\Controllers\Home;

$params = explode('/', $_GET['p']);

if ($params[0] != '') {
  // Stockage des variables controller et action (controller et methode)
  $controller = ucfirst($params[0]);
  $action = isset($params[1]) ? $params[1] : 'index';

  // Appel controller
  require_once('../src/controllers/'.$controller.'.php');
  // Instancie le controller
  $controller = new $controller();

  if (method_exists($controller, $action)) {
    // Appel de la methode
    $controller->$action();
  } else {
    http_response_code(404);
    echo "La page recherchée n'existe pas";
  }
} else {
  require_once('../src/controllers/Home.php');
  $controller = new Home();
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