<html>
  <head>
    <link rel="stylesheet" href="css/header/header.css">
  </head>
  <header>
    <img src="assets/img/Logos/logoAC2.png" alt="top">
    <nav>
      <?php
        if (isset($_SESSION['userId'])) {
      ?>
        <p>ID USER : <?= $_SESSION['userId'] /* TODO Récupérer le nom du user */?></p>
        <a href="/auth">Déconnectez-vous</a>
      <?php
        } else {
      ?>
      <a href="/auth">Connectez-vous</a>
      <a href="/register">Créez un compte</a>
      <?php
        }
      ?>
    </nav>
  </header>
</html>