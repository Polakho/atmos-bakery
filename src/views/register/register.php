<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Atmos Bakery | Nouveau compte</title>
</head>

<body>
  <section class="main">
    <?php
    $this->frontController->header();
    ?>
    <div class="form-container">
      <h3>Création de compte</h3>
      <form class="register-form" action="/auth/register" method="post">

        <div class="row">
          <div class="col">
            <label>Nom</label>
            <input class="form-control" placeholder="nom" type="text" name="f_name" required>
          </div>
          <div class="col">
            <label>Prénom</label>
            <input class="form-control" placeholder="prénom" type="text" name="name" required>
          </div>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input class="form-control" placeholder="adresse mail" type="email" name="mail" required>
        </div>

        <div class="form-group">
          <label>Mot de passe</label>
          <input class="form-control" placeholder="mot de passe" type="password" name="password" required>
        </div>

        <div class="form-group">
          <label>Confirmation du mot de passe</label>
          <input class="form-control" placeholder="confirmation du mot de passe" type="password" name="retypePassword" required>
        </div>
        <div class="form-register-bottom">
          <button class="btn btn-primary" type="submit">CRÉER</button>
          <?php
          if (isset($errorMsg)) {
            echo "<div class='alert alert-warning' role='alert'>$errorMsg</div>";
          }
          ?>
        </div>
      </form>
    </div>
    <?php
    $this->frontController->footer();
    ?>
  </section>
</body>

</html>