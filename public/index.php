<?php
session_start();

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
// define('ROOT', 'src/');
// echo ROOT;
// Pas sur d'utiliser cette methode de definir root
include "../src/controllers/router/router.php";