<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./src/css/index.css">
  <title>Atmos Bakery</title>
</head>
<body>
  <?php
    require 'vendor/autoload.php';
    require 'src/components/header/header.php';

    $router = new App\Router(dirname(__DIR__).'public/pages');
    $router
      ->get('/', '/public/pages/home/home', 'Accueil')
      ->get('/about', '/public/pages/about/about', 'À propos')
      ->run();

    // $router->map('GET', '/', function () {
    //   require 'public/pages/home/home.view.php';
    // }, 'home');
    // $router->map('GET', '/about', function () {
    //   require 'public/pages/about/about.view.php';
    // }, 'about');

    // $match = $router->match();
    // var_dump($router);
    // $match['target']();

    require 'src/components/footer/footer.php';
  ?>
</body>
</html>