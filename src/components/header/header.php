<html>
  <head>
    <link rel="stylesheet" href="../../css/header/header.css">
  </head>
  <header>
    <a href="/">
      <img src="../../assets/img/Logos/logoAC2.png" alt="top">
    </a>
    <nav>
      <?php
        if (isset($_SESSION['userId'])) {
      ?>
        <p>ID USER : <?= $_SESSION['userId'] /* TODO Récupérer le nom du user */?></p>
        <a href="/auth/logout">Déconnectez-vous</a>
      <?php
        } else {
      ?>
        <a href="/auth/login">Connectez-vous</a>
        <a href="/auth/register">Créez un compte</a>
      <?php
        }
      ?>
    </nav>
  </header>
</html>