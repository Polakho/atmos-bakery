<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login/login.css">
    <title>Atmos Bakery | Connexion</title>
</head>

<body>
    <section>
        <?php
        require '../src/components/header/header.php';
        ?>
        <form action="/login" method="post">
            <label for="mail">Email:</label>
            <input type="text" name="mail" id="mail">
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Connexion">
        </form>
        <?php
        require '../src/components/footer/footer.php';
        ?>
    </section>
</body>

</html>