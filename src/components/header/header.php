<html>
<link rel="shortcut icon" href="../../assets/favicon/favicon.ico" type="image/x-icon">
<style>
  <?php include './css/global.css'; ?>
</style>
<header class="large-header">
  <div class="nav-une">
    <a href="/">
      <img class="header-logo" src="../../assets/img/Logos/logoAC2.png" alt="top">
    </a>
    <a href="/product">Les produits</a>
    <a href="/about">Les magasins</a>
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
      <a href="/auth/logout">Déconnexion</a>
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
    include '../src/components/modales/cartModale.php';
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

</div>
<div class="notification-delete-product">
    Le produit a bien été supprimé
</div>
<div class="notification-change-quantity">
    La quantité a bien été changé
</div>

<script defer>
  <?php require_once('./js/cartModal.js'); ?>
</script>
<script defer>
  <?php require_once('./js/showMenu.js'); ?>
</script>

</html>