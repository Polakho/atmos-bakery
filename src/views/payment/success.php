<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atmos Bakery | Paiement abouti</title>
</head>

<body>
    <div class="footer-footer">
        <?php
        $this->frontController->header();

        ?>
        <section>
            <div class="payment-success">
                <h3>Atmos Corporation vous remercie pour votre commande.</h3>
                <h4>Transaction numéro <?= $checkout_session; ?></h4>
            </div>

        </section>


        <?php
        $this->frontController->footer();
        ?>
    </div>
</body>

</html>