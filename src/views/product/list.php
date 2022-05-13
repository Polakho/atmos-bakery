<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/product/list.css">
    <title>Atmos Bakery</title>
</head>
<body>
<?php
include '../src/components/header/header.php';
?>
<section class="main-section-background">
<h1>Listing de Produits  </h1>
<ul class="listing">
    <?php
    /** @var \App\Classes\Product $product */
    foreach ($products as $product){

        echo '<li class="card">
                  <img src="https://mapetiteassiette.com/wp-content/uploads/2019/05/shutterstock_553887610-e1557046359887-800x601.jpg" 
                  alt="Image Produit" style="width:100px; height:auto">
                  <h1>'.$product->getName().'</h1>
                  <p class="price">'.$product->getPrice().' $</p>
                  <p>'.$product->getDescription().'</p>
                  <p><button>Ajouter au panier</button></p>
            </li>';
    }
    ?>
</ul>
</section>
<section>
    <?php
    include '../src/components/footer/footer.php';
    ?>
</section>
</body>

</html>