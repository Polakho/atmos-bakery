<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/src/components/header/header.php';

$router = new AltoRouter();

$router->map('GET', '/', function () {
  require_once dirname(__FILE__) . '/public/views/home/index.php';
});
$router->map('GET', '/about', function () {
  require_once dirname(__FILE__) . '/public/views/about/index.php';
});
$match = $router->match();
if ($match !== null) {
  $match['target']();
}

require_once dirname(__FILE__) . '/src/components/footer/footer.php';
