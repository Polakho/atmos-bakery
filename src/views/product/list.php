<!DOCTYPE html>
<html lang="en">

<script>
    //Penser à changer l'url de l'api selon le vhost
    //Bien mettre un / après le api
    let baseUrl = "http://atmosdev.com/api/"
</script>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../../src/js/productList.js"></script>
    <title>Atmos Bakery</title>
</head>

<body>
    <?php
    $this->frontController->header();
    ?>
    <section class="main-section-background">
        <h1 class="titre">Nos Produits</h1>
        <div class="listing" data-pages="<?= $pages ?>">
            <?php
            require("../vendor/autoload.php");

            foreach ($list as $key => $array) {
                echo '<div class="page" data-page="page-' . ($key + 1) . '">';
                /** @var \App\Classes\Product $product */
                foreach ($array as $product) {
                    echo '<div class="card">
                  <img src="' . $product->getImage() . '" 
                  alt="Image Produit" style="width:200px; height:auto">
                  <h3>' . $product->getName() . '</h3>
                  <p class="price">' . $product->getPrice() . ' €</p>
                  <p>' . $product->getDescription() . '</p>
                  <button class="add-product" data-product-id="' . $product->getId() . '">+</button>
                  </div>';
                }
                echo '</div>';
            }
            ?>
            <div id="navigation">
                <button id="btn-prev">Prev</button>
                <p id="page-nbr">1</p>
                <button id="btn-next">Next</button>
            </div>

        </div>
    </section>
    <section>
        <!-- Reprendre -->
        <div class="notification-add-product">
            Le produit a bien été ajouté
        </div>
        <?php
        include "../src/components/modales/addProductModal.php";

        $this->frontController->footer();
        ?>
    </section>
</body>
<script><?php require_once('./js/productList.js'); ?></script>
</html>