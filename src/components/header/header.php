<html>

<head>
  <link rel="stylesheet" href="../../css/header/header.css">
</head>
<header>
  <a href="/">
    <img src="../../assets/img/Logos/logoAC2.png" alt="top">
  </a>
  <a href="/product">Les produits</a>
  <a href="/about">À propos</a>
  <nav>
    <?php
    if (isset($_SESSION['userId'])) {
      // var_dump($cart);
    ?>
      <p>ID USER : <?= $_SESSION['userId']; /* TODO Récupérer le nom du user */ ?></p>
        <span class="data-cart" data-cart-id="<?= $cart->getId()?>" data-user-id="<?= $_SESSION['userId'] ?>"></span>
      <a href="/auth/logout">Déconnectez-vous</a>
      <button onClick="showCart()"><img class="cart-icone" src="../../assets/img/cart/cart.png" alt="icone panier"></button>
    <?php
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

</html>
<script>
  let modalCart = document.querySelector('.modal-cart')
  let cartState = false;

  function showCart() {
    cartState = !cartState;
    if (cartState == false) {
      modalCart.classList.add("hidden")
    } else {
      modalCart.classList.remove("hidden")
    }
  }
</script>
