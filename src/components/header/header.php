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
    </div>
    <nav>
      <?php
        use App\Classes\Autoloader;
        use App\Models\UserModel;
        $userModel = new UserModel();
        if (isset($_SESSION['userId'])) {
            var_dump($cart);
      ?>
        <p>ID USER : <?= $_SESSION['userId'] /* TODO Récupérer le nom du user */?></p>
        <a href="/auth/logout">Déconnectez-vous</a>
            <button onClick="showCart()"><img class="cart-icone" src="../../assets/img/cart/cart.png" alt="icone panier"></button>
            <div class="modal-cart hidden">
                <div class="modal">
                    <div class="modal-header">
                        <h1>Mon panier</h1>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
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
<script>
    let modalCart = document.querySelector('.modal-cart')
    function showCart(){
        console.log("coucou")
        modalCart.classList.remove("hidden")
    }
</script>