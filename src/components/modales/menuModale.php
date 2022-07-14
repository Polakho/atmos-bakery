<div class="menu-container" style="visibility: hidden; opacity: 0;">

  <div class="menu-box">
    <button class="close-menu-btn" type="button" onClick="showMenu()">X</button>
    <?php
      if (isset($_SESSION['user']['id'])) {
    ?>
    <p class="account-name"><span><?=$_SESSION['user']['name']?></span></p>
    <?php
    }
    ?>

    <ul class="menu-list">
      <li class="menu-list-item"><a href="/">Accueil</a></li>
      <li class="menu-list-item"><a href="/product">Produits</a></li>
      <li class="menu-list-item"><a href="/about">À propos</a></li>

      <?php
      if (isset($_SESSION['user']['id'])) {
        if ($_SESSION['user']['roles'] === 'ADMIN') {
        ?>
        <li class="menu-list-item"><a href="/admin">Panel admin</a></li>
        <?php
        }
        ?>

        <li class="menu-list-item"><a href="/auth/logout">Déconnexion</a></li>
        <?php
      } else {
        ?>
        <li class="menu-list-item"><a href="/auth/login">Connexion</a></li>
        <li class="menu-list-item"><a href="/auth/register">Créer un compte</a></li>
        <?php
      }
      ?>
    </ul>
  </div>
</div>