<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/register/register.css">
  <title>Atmos Bakery | Nouveau compte</title>
</head>
<body>
  <section class="main">
    <?php
      include '../src/components/header/header.php';
    ?>
    <div class="form-container">
      <h2>Création de compte</h2>
      <form class="register-form" action="/auth/register" method="post">
        <?php
          if (isset($errorMsg)) {
            echo "<div class='alert alert-warning' role='alert'>$errorMsg</div>";
          }
        ?>
        <label for="name">Nom, prénom :</label>
        <input type="text" placeholder="" name="name" required>
        <label for="mail">Adresse mail :</label>
        <input type="text" placeholder="adresse mail" name="mail" required>
        <label for="password">Mot de passe :</label>
        <input type="password" placeholder="mot de passe" name="password" required>

        <label for="retypePassword">Tapez votre mot de passe à nouveau :</label>
        <input type="password" placeholder="mot de passe" name="retypePassword" required>
        <button type="submit">CRÉER</button>
      </form>
    </div>
    <?php
      include '../src/components/footer/footer.php';
    ?>
  </section>
</body>
</html>