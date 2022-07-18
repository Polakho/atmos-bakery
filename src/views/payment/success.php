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
                <img src="../../assets/img/payment/valid-transaction.png" alt="Icon valide">
                <h3 class="valid-transaction">Merci pour votre commande.</h3>
                <p class="valid-transaction">Vous recevrez un mail d'ici peu avec le récapitulatif de la commade.</p>
                <p class="valid-transaction">Transaction numéro <?= $checkout_session; ?></h4>
            </div>
        </section>


        <?php
        $this->frontController->footer();
        ?>
    </div>
</body>

</html>