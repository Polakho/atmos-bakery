<?php

use App\Classes\Autoloader;
use App\Models\ProductModel;
use App\Models\ScheduleModel;
use App\Models\UserModel;

require "../src/classes/Autoloader.php";
Autoloader::register();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/home/home.css">
  <title>Atmos Bakery</title>
</head>

<body>
  <?php
  include '../src/components/header/header.php';
  ?>
  <section class="main-section-background">
    C'est la homepage la
    <br>
  </section>
  <section>
    <?php
    include '../src/components/footer/footer.php';
    ?>
  </section>
</body>

</html>