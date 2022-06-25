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
      <span class="data-cart" data-cart-id="<?= $cart->getId() ?>" data-user-id="<?= $_SESSION['userId'] ?>"></span>
      <a href="/auth/logout">Déconnectez-vous</a>
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
<section>
  <div class="notification-del-contain">
    Le produit a bien été supprimé du panier.
  </div>
  <div class="notification-change-contain">
    La quantité a été changé.
  </div>
  <div class="blur">
    <span></span>
  </div>
</section>


</html>
<script>
  let modalCart = document.querySelector('.modal-cart')
  let modalBody = document.querySelector('.modal-cart .modal-body')
  let cartState = false;
  let cartId = document.querySelector(".data-cart").getAttribute("data-cart-id")
  let notifDel = document.querySelector('.notification-del-contain');
  let notifQuantityChanged = document.querySelector('.notification-change-contain');
  let btnClose = document.querySelector(".close");
  let blurBg = document.querySelector(".blur");

  btnClose.onclick = function() {
    cartState = !cartState
    blurBg.classList.remove("displayVisible");
    blurBg.classList.add("hidden");
    modalCart.classList.remove("displayFlex")
    modalCart.classList.add("hidden")
    clearBox(modalBody)
  }

  blurBg.onclick = function() {
    if (blurBg.classList.contains("hidden")) {

    } else {
      blurBg.classList.remove("displayVisible");
      blurBg.classList.add("hidden");
      cartState = !cartState
      modalCart.classList.remove("displayFlex")
      modalCart.classList.add("hidden")
      clearBox(modalBody)
    }
  }


  function showCart() {
    cartState = !cartState;
    if (cartState == false) {
      modalCart.classList.add("hidden")
      modalCart.classList.remove("displayFlex")
      blurBg.classList.remove("displayVisible");
      blurBg.classList.add("hidden");
      clearBox(modalBody)

    } else {
      modalCart.classList.remove("hidden")
      modalCart.classList.add("displayFlex")
      blurBg.classList.remove("hidden");
      blurBg.classList.add("displayVisible");

      let div = document.createElement("div")
      div.classList.add("body-contain")
      let p2 = document.createElement("p")
      let btnCheckout = document.createElement("button");
      let totalPrice = 0;
      let post = {
        cart_id: cartId,

      }
      fetch(baseUrl + "getContainsForCart", {
        method: 'post',
        body: JSON.stringify(post),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      }).then((response) => {
        return response.json()
      }).then((res) => {
        if (res.list) {
          res.list.map(function(contain) {
            let h3 = document.createElement("h3")
            let btn = document.createElement("button");
            let p = document.createElement("p");
            let br = document.createElement("br");
            btn.classList.add("delete-contain");
            btn.setAttribute("data-id", contain.id)
            h3.innerHTML = contain.product.name
            btn.innerHTML = "Supprimer";
            let priceVerif = "" + contain.product.price + "";
            let price = priceVerif.replace(/,/g, ".");
            price = (price * contain.quantity);
            totalPrice = totalPrice + price;
            p.innerHTML = "Prix: " + price + " €";
            let label = document.createElement("label")
            label.innerHTML = "Quantité: "
            div.appendChild(h3)
            div.appendChild(btn)
            btn.onclick = function() {
              let post = {
                contain_id: btn.getAttribute("data-id")
              }
              console.log(post);
              fetch(baseUrl + "deleteContain", {
                method: 'post',
                body: JSON.stringify(post),
                headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json',
                }
              }).then((response) => {
                return response.json()
              }).then((res) => {
                notifDel.classList.add("show");
                setTimeout(() => {
                  notifDel.classList.remove("show");
                }, 3000);
                console.log(post)
                showCart()
              }).catch((error) => {
                console.log(error)
              })
            }
            let btnQuantity = document.createElement("button");
            let input = document.createElement("input");
            input.classList.add("contain-quantity")
            btnQuantity.classList.add("change-quantity");
            btnQuantity.innerHTML = "Changer";
            input.value = contain.quantity;
            div.appendChild(label)
            div.appendChild(p);
            div.appendChild(input)
            div.appendChild(btnQuantity)
            div.appendChild(br);
            input.onchange = function() {
              let quantityChanged = input.value

              console.log(contain.quantity + ' | ' + quantityChanged)

              if (quantityChanged !== contain.quantity) {
                btnQuantity.onclick = function() {
                  let post = {
                    contain_id: contain.id,
                    quantity: quantityChanged
                  }
                  console.log(post);
                  fetch(baseUrl + "changeQuantityOfContain", {
                    method: 'post',
                    body: JSON.stringify(post),
                    headers: {
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                    }
                  }).then((response) => {
                    return response.json()
                  }).then((res) => {
                    notifQuantityChanged.classList.add("show");
                    setTimeout(() => {
                      notifQuantityChanged.classList.remove("show");
                    }, 3000);
                    btnQuantity.removeAttribute("onclick");
                    showCart()
                  }).catch((error) => {
                    console.log(error)
                  })
                }
              }

            }
            modalBody.appendChild(div)

          })
          p2.innerHTML = "Total: " + totalPrice + " €";
          btnCheckout.innerHTML = "Checkout";
          modalBody.appendChild(p2)
          modalBody.appendChild(btnCheckout)
          btnCheckout.onclick = function() {
            window.location.replace("/checkout");
          }
        } else if (res.message) {
          let div = document.createElement("div")
          let p = document.createElement("p")
          p.innerHTML = "Panier vide"
          div.appendChild(p)
          modalBody.appendChild(div)

        }

      }).catch((error) => {
        console.log(error)
      })

    }
  }
</script>