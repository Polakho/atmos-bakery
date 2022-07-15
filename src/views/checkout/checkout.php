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
            if (http_response_code() === 999) {
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
                <button><a href="/payment">Continuer vers le paiement</a></button>
            </div>
        </section>
        <?php
        $this->frontController->footer();
        ?>

    </section>
    <script>
        const baseHref = "/checkout/updateContain?updateid=##&quantity="

        function changeInputValue(containId) {
            console.log(containId)
            let hrefReplaced = baseHref
            hrefReplaced.replace(/[0-9]/g, "##")
            let inputValue = document.getElementById("quantity-" + containId).value;
            hrefReplaced = hrefReplaced.replace("updateid=##", "updateid=" + containId)
            console.log(hrefReplaced)
 
            console.log(inputValue)
            console.log(hrefReplaced + inputValue)
            document.getElementById("change-quantity-" + containId).href = hrefReplaced + inputValue
        }
    </script>
</body>


</html>