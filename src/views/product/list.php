<!DOCTYPE html>
<html lang="en">

<script>
    let baseUrl = "http://93.4.7.36:8455/api/"
</script>

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
    <section class="main-section-background list-section">
        <!-- <h1 class="titre">Nos Produits</h1> -->
        <div class="listing" data-pages="<?= $pages ?>">
            <?php
            require("../vendor/autoload.php");

            foreach ($list as $key => $array) {
                ?>
                <div class="page" data-page="page-<?=($key + 1)?>">
                    <?php
                    /** @var \App\Classes\Product $product */
                    foreach ($array as $product) {
                        ?>
                        <div class="card">
                            <div class="product-image">
                                <img src="<?= $product->getImage() ?>" alt="Image Produit" style="width:200px; height:auto">
                            </div>
                            <div class="product-info">
                                <div class="head-product-text">
                                <h3 class="product-title"><?= $product->getName() ?></h3>
                                <p class="product-card-price"><?= $product->getPrice() ?>€</p>
                                </div>
                                <p class="product-descrition"><?= $product->getDescription() ?></p>
                            </div>
                            <button class="add-product" data-product-id="<?= $product->getId() ?>">Ajouter au panier</button>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
                // echo '<div class="page" data-page="page-' . ($key + 1) . '">';
                // /** @var \App\Classes\Product $product */
                // foreach ($array as $product) {
                //     echo '<div class="card">
                //   <img src="' . $product->getImage() . '" 
                //   alt="Image Produit" style="width:200px; height:auto">
                //   <h3>' . $product->getName() . '</h3>
                //   <p class="price">' . $product->getPrice() . ' €</p>
                //   <p>' . $product->getDescription() . '</p>
                //   <button class="add-product" data-product-id="' . $product->getId() . '">+</button>
                //   </div>';
                // }
                // echo '</div>';
            }
            ?>
            <div id="navigation">
                <button id="btn-prev">Prev</button>
                <p id="page-nbr">1</p>
                <button id="btn-next">Next</button>
            </div>

        </div>
        <?php $this->frontController->footer(); ?>
    </section>
    <div>
        <!-- Reprendre -->
        <div class="notification-add-product">
            Le produit a bien été ajouté
        </div>
        <?php
        include "../src/components/modales/addProductModal.php";
        ?>
    </div>
</body>
<script defer><?php require_once('./js/productList.js'); ?></script>

</html>