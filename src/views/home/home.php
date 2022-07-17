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
  <section class="unclick">
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
    <div class="random-products">
      <div class="presentation-3-produits">
        <?php
          /** @var \App\Classes\Product $product */
          foreach ($products as $product) {
            ?>
            <div class="card">
              <div class="product-image">
                <img src="<?= $product->getImage() ?>" alt="Image Produit" style="width:200px; height:auto">
              </div>
              <div class="product-info">
                <h3><?= $product->getName() ?></h3>
                <p class="price"><?= $product->getPrice() ?>€</p>
                <p><?= $product->getDescription() ?></p>
              </div>
              <button class="add-product" data-product-id="<?= $product->getId() ?>">+</button>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <?php
    $this->frontController->footer();
    ?>
  </section>
</body>

</html>