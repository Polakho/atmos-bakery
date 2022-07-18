<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atmos Bakery | À propos</title>
</head>

<body>
  <div class="footer-footer">
    <?php
    $this->frontController->header();

    foreach ($stores as $store)
    {
      ?>

        <section class="about-item">
          <div class="picture-wrapper about-item-wrapper">
            <?php
            if (isset($store['image'])) {
              ?>
              <img src="<?= $store['image'] ?>" alt="<?= $store['name'] ?>">
              <?php
            } else {
            ?>
              <img src="" alt="<?= $store['name'] ?>" class="store-image acLogo">
            <?php
            }
            ?>
          </div>

          <div class="info-wrapper about-item-wrapper">
            <h1 class="info-store-title"><?= $store['name'] ?></h1>
            <p class="info-store-description isp"><?= $store['description'] ?></p>
            <p class="info-store-contact isp"><span>Contact</span> : <?= $this->formatPhone($store['phone']) ?></p>
            <p class="info-store-adresse isp"><span>Adresse</span> : <?= $store['address'] ?></p>
          </div>
        </section>

      <?php
    }
    ?>
    
    <?php
    $this->frontController->footer();
    ?>
  </div> 
</body>

</html>