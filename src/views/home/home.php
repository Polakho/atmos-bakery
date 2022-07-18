<!DOCTYPE html>
<html lang="en">

<script>
    //Penser à changer l'url de l'api selon le vhost
    //Bien mettre un / après le api
    let baseUrl = "http://93.4.7.36:8455/api/"
</script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atmos Bakery</title>
</head>

<body>
  <?php
  $this->frontController->header();

  ?>
  <section class="unclick">
    <div class="mask"></div>
    <div class="hp-ad">
      <h1 class="hp-title">Découvrez nos produits</h1>
      <br>
      <a href="#pageDown" class="arrow-down">
        <img src="../../assets/svgs/angles-down-solid.svg" alt="arrow-down">
      </a>
    </div>
  </section>
  <section id="pageDown">
    <div class="random-products">
      <div class="presentation-3-produits">
        <?php
          /** @var \App\Classes\Product $product */
          foreach ($products as $product) {
            ?>
            <div class="card">
              <div class="product-image">
                <img src="<?= $product->getImage() ?>" alt="Image Produit" style="width:200px; height:auto">
              </div>
              <div class="product-info">
                <div class="head-product-text">
                  <h3 class="product-title"><?= $product->getName() ?></h3>
                  <p class="product-card-price"><?= $product->getPrice() ?>€</p>
                </div>
                <p class="product-descrition"><?= $product->getDescription() ?></p>
              </div>
              <button class="add-product" data-product-id="<?= $product->getId() ?>">Ajouter au panier</button>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <?php
    $this->frontController->footer();
    ?>
  </section>
  <div class="notification-add-product">
      Le produit a bien été ajouté
  </div>
  <?php
  include "../src/components/modales/addProductModal.php";
  ?>
</body>

<script defer>
    // GESTION AJOUT PRODUIT PANIER
    let currentQuantity = document.querySelector("#product-quantity").textContent;
    let btnMore = document.querySelector("#btn-more");
    let btnLess = document.querySelector("#btn-less");

    function visibleBtnQuantity() {
        if (currentQuantity == 1) {
            btnLess.style.visibility = "hidden";
        } else {
            btnLess.style.visibility = "visible";
        };
    };
    visibleBtnQuantity();

    btnMore.addEventListener("click", function() {
        currentQuantity++;
        document.querySelector("#product-quantity").innerHTML = (currentQuantity);
        visibleBtnQuantity();
    });

    btnLess.addEventListener("click", function() {
        if (currentQuantity > 1) {
            currentQuantity--;
            document.querySelector("#product-quantity").innerHTML = (currentQuantity);
            visibleBtnQuantity();
        }
    });

    // GESTION DE LA Ajout produit
    let modalState = false;
    let modal = document.querySelector('.modal-add-product');
    let modalHeader = document.querySelector('.modal-add-product .modal-header');

    function showModal() {
        modalState = !modalState;
        if (modalState == false) {
            modal.classList.add("hidden");
            clearBox(modalHeader);
        } else {
            modal.classList.remove("hidden");
        }
    };

    function clearBox(div) {
        while (div.firstChild) {
            div.removeChild(div.firstChild);
        }
        div.removeAttribute("data-product-id");
        document.querySelector("#product-quantity").innerHTML = "1";
        currentQuantity = 1;
        visibleBtnQuantity();
    };

    let btnCancel = document.querySelector(".cancel");

    btnCancel.addEventListener("click", function(){
        showModal();
        clearBox(modalHeader);
    })

    let AllBtnAdd = document.querySelectorAll(".add-product");

    AllBtnAdd.forEach(function(btn, index) {
        btn.addEventListener("click", function() {
            showModal();
            let product_id = btn.getAttribute("data-product-id");
            let post = {
                product_id: product_id,
            }
            fetch(baseUrl + "getProductById", {
                method: 'post',
                body: JSON.stringify(post),
                /* headers: {
                   'Accept': 'application/json',
                   'Content-Type': 'application/json',
                 }*/
            }).then((response) => {
                return response.json();
            }).then((res) => {
                console.log(res);
                modalHeader.textContent = res.name;
                modalHeader.setAttribute("data-product-id", product_id);
            }).catch((error) => {
                console.log(error);
            });
        });
    });

    // GESTION DE LA DATA DU CART
    let cart = document.querySelector(".data-cart");
    let btnAddProduct = document.querySelector(".add-product-action");
    let notif = document.querySelector('.notification-add-product');
    btnAddProduct.addEventListener("click", function() {
        let product_id = modalHeader.getAttribute("data-product-id");
        let quantity = document.querySelector("#product-quantity").textContent;
        let post = {
            product_id: product_id,
            cart_id: cart.getAttribute("data-cart-id"),
            quantity: quantity
        };
        fetch(baseUrl + "addToCart", {
            method: 'post',
            body: JSON.stringify(post),
            /*headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            }*/
        }).then((response) => {
            return response.json();
        }).then((res) => {
            if (res.contain_id || res.quantity) {
                notif.classList.add("show");
                setTimeout(() => {
                    notif.classList.remove("show");
                }, 3000);
                showModal();
            }
        }).catch((error) => {
            console.log(error);
        });
    });

</script>
</html>