<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atmos Bakery | Paiement</title>
</head>

<body>
    <section class="main">
        <?php
        $this->frontController->header();
        ?>
        <section class="main-section-background">
            <?php
            if (http_response_code() === 401) { // Si verif cartId n'appartient pas à userId
                var_dump('Unauthorized');
                echo "<div class='alert alert-warning' role='alert'>Vous ne pouvez pas modifier le panier de quelqu'un d'autre.</div>";
            }
            ?>
            <div class="active-cart">
                <?php
                foreach ($contains as $contain) {
                    $product = $this->productModel->getProductById($contain['id']);

                ?> <div class="product <?= $product->getId() ?>">
                        <img src="<?= $product->getImage() ?>" alt="image product <?= $product->getId() ?>">
                        <p><?= $product->getName() ?></p>
                        <label for="quantity">Quantité:</label>
                        <input type="text" value="<?= $contain['quantity'] ?>" name="quantity" id="quantity-<?= $contain['id'] ?>" onchange="changeInputValue(<?= $contain['id'] ?>)" />
                        <button class="btn-update"><a href="" id="change-quantity-<?= $contain['id'] ?>" class="text-crud">Modifier</a></button>
                        <button class="btn-delete"><a href="/checkout/deleteContain?deleteid=<?= $contain['id'] ?>" class="text-crud">Supprimer</a></button>
                    </div>
                <?php
                }
                ?>

            </div>
            <div class="checkout">
                <a href="/stripe/payment">Continuer vers le paiement</a>
            </div>
        </section>
        <?php
        $this->frontController->footer();
        ?>

    </section>
    <script>
        const baseHref = "/checkout/updateContain?containid=##&quantity="

        function changeInputValue(containId) {
            let hrefReplaced = baseHref
            hrefReplaced.replace(/[0-9]/g, "##")
            let inputValue = document.getElementById("quantity-" + containId).value; //Récup la value de l'input changé
            hrefReplaced = hrefReplaced.replace("containid=##", "containid=" + containId) //Remplace le contain id
            document.getElementById("change-quantity-" + containId).href = hrefReplaced + inputValue //Remplace le href du <a> Modifier
        }
    </script>
</body>


</html>