<?php

$action = substr(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), 1);

switch ($action) {
  case 'about':
    require "../src/controllers/about.controller.php";
    break;
  case 'register':
    require "../src/controllers/register.controller.php";
    break;
  case 'auth':
    require "../src/controllers/auth.controller.php";
    break;

  default:
    require "../src/controllers/home.controller.php";
    break;
}