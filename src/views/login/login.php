<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/login/login.css">
    <title>Atmos Bakery | Connexion</title>
</head>

<body>
    <section class="main">
        <?php
        require '../src/components/header/header.php';
        ?>
        <div class="form-container">
            <h2>Connectez-vous</h2>
            <form class="login-form" action="/Auth/login" method="post">
                <?php
                if (isset($errorMsg)) {
                    echo "<div class='alert alert-warning' role='alert'>$errorMsg</div>";
                }
                ?>
                <label for="mail">Email :</label>
                <input type="text" name="mail" id="mail">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password">
                <button type="submit">Connexion</button>
            </form>
        </div>
        <?php
        require '../src/components/footer/footer.php';
        ?>
    </section>
</body>

</html>