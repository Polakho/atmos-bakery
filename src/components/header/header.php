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
      <a href="">Commander</a>
      <a href="">À propos</a>
      nice
    </div>
    <nav>
      <?php
        use App\Classes\Autoloader;
        use App\Models\UserModel;
        $userModel = new UserModel();
        if (isset($_SESSION['userId'])) {
      ?>
        <p class="profile-name">Bonjour, 
          <span class="bold-name">
            <?php
              $res = $userModel->getUserById($_SESSION['userId']);
              echo $res->getName();
            ?>
          </span>
        </p>
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