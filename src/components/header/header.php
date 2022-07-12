<html>
  <header>
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
          <span class="user user-user"><?php echo $_SESSION['user']['name']?></span>
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

  <script type="text/javascript">
    // SELECTEURS
  let modalCart = document.querySelector('.modal-cart');
  let modalBody = document.querySelector('.modal-cart .modal-body');
  let cartState = false;
  let cartId = document.querySelector(".data-cart").getAttribute("data-cart-id");
  let notifDel = document.querySelector('.notification-del-contain');
  let notifQuantityChanged = document.querySelector('.notification-change-contain');
  let btnClose = document.querySelector(".close");
  let blurBg = document.querySelector(".blur");

  // FONCTIONS MODALE
  // Fermer la modale
  btnClose.onclick = function() {
    cartState = !cartState;
    blurBg.classList.remove("displayVisible");
    blurBg.classList.add("hidden");
    modalCart.classList.remove("displayFlex");
    modalCart.classList.add("hidden");
    // clearBox(modalBody);
  };

  blurBg.onclick = function() {
    if (blurBg.classList.contains("hidden")) {
      return;
    } else {
      blurBg.classList.remove("displayVisible");
      blurBg.classList.add("hidden");
      cartState = !cartState;
      modalCart.classList.remove("displayFlex");
      modalCart.classList.add("hidden");
      // clearBox(modalBody);
    };
  };

  // Ouverture et Récupération des items du cart
  function showCart() {
    cartState = !cartState;
    if (cartState == false) {
      modalCart.classList.add("hidden");
      modalCart.classList.remove("displayFlex");
      blurBg.classList.remove("displayVisible");
      blurBg.classList.add("hidden");
      // clearBox(modalBody);
    } else {
      modalCart.classList.remove("hidden");
      modalCart.classList.add("displayFlex");
      blurBg.classList.remove("hidden");
      blurBg.classList.add("displayVisible");

      let itemList = document.createElement("div");
      itemList.classList.add("body-contain");

      let p2 = document.createElement("p");
      let totalPrice = 0;
      let post = {
        cart_id: cartId,
      };

      fetch(baseUrl + "getContainsForCart", {
        method: 'post',
        body: JSON.stringify(post),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      }).then((response) => {
        return response.json();
      }).then((res) => {
        if (res.list) {
          res.list.map(function(contain) {
            // Création d'item
            // Wrapper par item
            let itemContainer = document.createElement("div");
            itemContainer.classList.add("item-container");

            let btn = document.createElement("button");
            btn.classList.add("delete-contain");
            btn.setAttribute("data-id", contain.id);
            btn.innerHTML = "Supprimer";
            btn.onClick = function() {
              let post = {
                contain_id: btn.getAttribute("data-id")
              };
              console.log(post);

              fetch(baseUrl + "deleteContain", {
                method: 'post',
                body: JSON.stringify(post),
                headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json',
                }
              }).then((response) => {
                return response.json();
              }).then((res) => {
                notifDel.classList.add("show");
                setTimeout(() => {
                  notifDel.classList.remove("show");
                }, 3000);
                console.log(post);
                showCart();
              }).catch((error) => {
                console.log(error);
              });
            };

            let h3 = document.createElement("h3");
            h3.innerHTML = contain.product.name;

            let p = document.createElement("p");

            let price = parseFloat(contain.product.price).toFixed(2);
            itemTotalPrice = parseFloat(price * contain.quantity).toFixed(2);
            p.innerHTML = `Prix : ${itemTotalPrice}€ (${price}€/u)`;
            // Ajout au total du prix
            totalPrice = totalPrice + itemTotalPrice;

            let label = document.createElement("label");
            label.innerHTML = "Quantité: ";
            
            let input = document.createElement("input");
            input.classList.add("contain-quantity");
            input.value = contain.quantity;
            input.onchange = function() {
              let quantityChanged = input.value;

              console.log(contain.quantity + ' | ' + quantityChanged);

              if (quantityChanged !== contain.quantity) {
                btnQuantity.onclick = function() {
                  let post = {
                    contain_id: contain.id,
                    quantity: quantityChanged
                  };
                  console.log(post);
                  fetch(baseUrl + "changeQuantityOfContain", {
                    method: 'post',
                    body: JSON.stringify(post),
                    headers: {
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                    }
                  }).then((response) => {
                    return response.json();
                  }).then((res) => {
                    notifQuantityChanged.classList.add("show");
                    setTimeout(() => {
                      notifQuantityChanged.classList.remove("show");
                    }, 3000);
                    btnQuantity.removeAttribute("onclick");
                    showCart();
                  }).catch((error) => {
                    console.log(error);
                  });
                };
              };
            };

            let btnQuantity = document.createElement("button");
            btnQuantity.classList.add("change-quantity");
            btnQuantity.innerHTML = "Changer";
            
            // Ajout au wrapper
            let itemContainerHead = document.createElement("div");
            itemContainerHead.classList.add("item-container-head");
            itemContainerHead.appendChild(h3);
            itemContainerHead.appendChild(btn);
            itemContainer.appendChild(itemContainerHead);

            let itemContainerDetail = document.createElement("div");
            itemContainerDetail.classList.add("item-container-detail");
            let quantitySector = document.createElement("div");
            quantitySector.classList.add("quantity-sector");
            quantitySector.appendChild(label);
            quantitySector.appendChild(input);
            quantitySector.appendChild(btnQuantity);
            itemContainerDetail.appendChild(quantitySector);
            p.classList.add("item-price");
            itemContainerDetail.appendChild(p);
            itemContainer.appendChild(itemContainerDetail);

            itemList.appendChild(itemContainer);
            modalBody.appendChild(itemList);
          });

          p2.innerHTML = `Total : ${totalPrice}€`;

          let btnCheckout = document.createElement("button");
          btnCheckout.innerHTML = "Checkout";
          btnCheckout.onclick = function() {
            window.location.replace("/checkout");
          };

          modalBody.appendChild(p2);
          modalBody.appendChild(btnCheckout);
        } else if (res.message) {
          if (!document.querySelector(".empty")) {
            let div = document.createElement("div");
            div.classList.add("empty");
            let p = document.createElement("p");
            p.innerHTML = "Panier vide";
            div.appendChild(p);
            modalBody.appendChild(div);
          };
        };
      }).catch((error) => {
        console.log(error);
      });
    };
  };
  </script>
</html>
