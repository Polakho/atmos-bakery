<?php

$action = substr(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), 1);

switch ($action) {
  case 'about':
    require "../controllers/about.controller.php";
    break;
  default:
    require "../controllers/home.controller.php";
    break;
}