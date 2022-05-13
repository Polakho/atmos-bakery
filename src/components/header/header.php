<html>
  <head>
    <link rel="stylesheet" href="../../css/header/header.css">
  </head>
  <header>
    <div class="main-nav">
      <a href="/">
        <img src="../../assets/img/Logos/logoAC2.png" alt="top">
      </a>
      <a href="">Les produits</a>
      <a href="">Code source</a>
      <a href="">À propos</a>
    </div>
    <nav>
      <?php
        if (isset($_SESSION['userId'])) {
      ?>
        <p class="profile-name">Bonjour, <span class="bold-name"><?= $_SESSION['userId'] /* TODO Récupérer le nom du user */?></span></p>
        <a href="/auth/logout">Déconnexion</a>
      <?php
        } else {
      ?>
        <a href="/auth/login">Connection</a>
        <a href="/auth/register" class="btn-wrapper"><span class="btn-content">Inscription</span></a>
      <?php
        }
      ?>
    </nav>
  </header>
</html>