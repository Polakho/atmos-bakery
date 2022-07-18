<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atmos Bakery | Paiement echoué</title>
</head>

<body>
    <div class="footer-footer">
        <?php
        $this->frontController->header();

        ?>
        <section>
            <div class="payment-failed">
                <h3>Nous sommes désolé...</h3>
                <h3>Une erreur est survenue lors de la validation de paiement.</h3>
                <h3>Redirection...</a></h3>
                <h5><a href="/checkout">Cliquez ici si vous n'etes pas redirigés automatiquement.</a></h5>
            </div>

        </section>


        <?php
        $this->frontController->footer();
        ?>
    </div>
</body>

</html>