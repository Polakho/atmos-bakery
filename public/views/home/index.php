<?php
use App\Autoloader;
use App\Product;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./src/css/home/home.css">
  <title>Atmos Bakery</title>
</head>
<body>
  <?php
  require 'src/components/header/header.php';
  ?>
  <section class="main-section-background">
    C'est la homepage la
      <br>

      <?php
      require "src/classes/Autoloader.php";
      Autoloader::register();

      $Product = new Product();
      $data = $Product->getAllProduct();
      var_dump($data);



      ?>
  </section>
  <section>
    <?php
      require 'src/components/footer/footer.php';
    ?>
  </section>
</body>
</html>