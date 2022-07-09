<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atmos Bakery</title>
</head>

<body>
  <?php
  $this->frontController->header();

  ?>
  <section>
    <div class="mask"></div>
    <div class="hp-ad">
      <h1 class="hp-title">Découvrez nos produits</h1>
      <br>
      <a href="#pageDown" class="arrow-down">
        <img src="../../assets/svgs/angles-down-solid.svg" alt="arrow-down">
      </a>
    </div>
  </section>
  <section id="pageDown">
    <?php
    $this->frontController->footer();
    ?>
  </section>
</body>

</html>