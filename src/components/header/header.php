<html>
<header class="large-header">
  <div class="nav-une">
    <a href="/">
      <img class="header-logo" src="../../assets/img/Logos/logoAC2.png" alt="top">
    </a>
    <a href="/product">Les produits</a>
    <a href="/about">À propos</a>
  </div>
  <nav>
    <?php
    if (isset($_SESSION['user']['id'])) {
      require_once '../src/classes/User.php';
      $user = new App\Classes\User();
      // var_dump($cart);
    ?>
      <div class="bjr-user">
        <p class="user">Bonjour,</p>
        <span class="user user-user"><?php echo $_SESSION['user']['name'] ?></span>
      </div>
      <span class="data-cart" data-cart-id="<?= $cart->getId() ?>" data-user-id="<?= $_SESSION['user']['id'] ?>"></span>
      <?php if (isset($_SESSION['user']['roles']) && $_SESSION['user']['roles'] === 'ADMIN') { ?>
        <a href="/admin" target="_blank">Admin panel</a>
      <?php } ?>
      <a href="/auth/logout">Déconnection</a>
      <?php if ($_SERVER['REQUEST_URI'] <> '/checkout') { ?>
        <button class="show-cart" onClick="showCart()"><img class="cart-icone" src="../../assets/img/cart/cart.png" alt="icone panier"></button>
      <?php
      }
      include '../src/components/modales/cartModale.php';
    } else if ($_SERVER['REQUEST_URI'] === '/auth/login') {
      ?>
      <a href="/auth/register">Créez un compte</a>

    <?php
    } else if ($_SERVER['REQUEST_URI'] === '/auth/register') {
    ?>
      <a href="/auth/login">Connectez-vous</a>

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

<header class="small-header">
  <div class="logo-mobile">
    <a href="/">
      <img class="header-logo" src="../../assets/img/Logos/logoAC2.png" alt="top">
    </a>
  </div>

  <?php require "../src/components/modales/menuModale.php"; ?>
  <button type="button" class="show-menu-btn" onClick="showMenu()">Menu</button>
</header>

<div class='notification blur-modal'>
  <div class="notification-del-contain">
    Le produit a bien été supprimé du panier.
  </div>
  <div class="notification-change-contain">
    La quantité a été changé.
  </div>
  <div class="blur">
    <span></span>
  </div>
</div>

<script defer>
  <?php require_once('./js/cartModal.js'); ?>
</script>
<script defer>
  <?php require_once('./js/showMenu.js'); ?>
</script>

</html>