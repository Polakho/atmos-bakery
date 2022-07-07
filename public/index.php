<?php
require_once('../vendor/autoload.php');
session_start();
ini_set('display_errors', '1');

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
// define('ROOT', 'src/');
// echo ROOT;
// Pas sur d'utiliser cette methode de definir root
require_once '../src/classes/Autoloader.php';
\App\Classes\Autoloader::register();

?>
<link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
<style><?php include './css/global.css'; ?></style>
<?php

include_once "../src/controllers/router/router.php";