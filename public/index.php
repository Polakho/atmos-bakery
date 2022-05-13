<?php
session_start();
ini_set('display_errors', '1');

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
// define('ROOT', 'src/');
// echo ROOT;
// Pas sur d'utiliser cette methode de definir root
require '../src/classes/Autoloader.php';
\App\Classes\Autoloader::register();
include "../src/controllers/router/router.php";