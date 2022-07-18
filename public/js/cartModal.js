// SELECTEURS
let modalCart = document.querySelector('.modal-cart');
let modalBody = document.querySelector('.modal-cart .modal-body');
let cartState = false;
let cartId = document.querySelector(".data-cart").getAttribute("data-cart-id");
let notifDel = document.querySelector('.notification-del-contain');
let notifQuantityChanged = document.querySelector('.notification-change-contain');
let btnClose = document.querySelector(".close");
let blurBg = document.querySelector(".blur");
let header = document.querySelector("header");

// FONCTIONS MODALE
// clearBox
function clearBox(div) {
  while (div.firstChild) {
    div.removeChild(div.firstChild);
  }
  div.removeAttribute("data-product-id");
  document.querySelector("#product-quantity").innerHTML = "1";
  currentQuantity = 1;
  visibleBtnQuantity();
};
// Fermer la modale
btnClose.onclick = function () {
  cartState = !cartState;
  blurBg.classList.remove("displayVisible");
  blurBg.classList.add("hidden");
  modalCart.classList.remove("displayFlex");
  modalCart.classList.add("hidden");
  clearBox(modalBody);
};

blurBg.onclick = function () {
  if (blurBg.classList.contains("hidden")) {
    return;
  } else {
    blurBg.classList.remove("displayVisible");
    blurBg.classList.add("hidden");
    cartState = !cartState;
    modalCart.classList.remove("displayFlex");
    modalCart.classList.add("hidden");
    clearBox(modalBody);
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
    clearBox(modalBody);
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
      method: 'POST',
      body: JSON.stringify(post),
    }).then((response) => {
      return response.json();
    }).then((res) => {
      if (res.list) {
        res.list.map(function (contain) {
          // Création d'item
          // Wrapper par item
          let itemContainer = document.createElement("div");
          itemContainer.classList.add("item-container");

          let btn = document.createElement("button");
          console.log(btn)
          btn.classList.add("delete-contain");
          btn.setAttribute("data-id", contain.id);
          btn.innerHTML = "Supprimer";
          console.log(btn.getAttribute("data-id"))
          btn.onclick = function () {
            let post = {
              contain_id: btn.getAttribute("data-id")

            };

            fetch(baseUrl + "deleteContain", {
              method: 'POST',
              body: JSON.stringify(post),
              /*headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
              }*/
            }).then((response) => {
              return response.json();
            }).then((res) => {
              console.log(res)
              notifDel.classList.add("show");
              setTimeout(() => {
                notifDel.classList.remove("show");
              }, 3000);
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
          totalPrice = parseFloat(totalPrice) + parseFloat(itemTotalPrice);

          let label = document.createElement("label");
          label.innerHTML = "Quantité: ";

          let input = document.createElement("input");
          input.classList.add("contain-quantity");
          input.value = contain.quantity;
          input.onchange = function () {
            let quantityChanged = input.value;

            console.log(contain.quantity + ' | ' + quantityChanged);

            if (quantityChanged !== contain.quantity) {
              btnQuantity.onclick = function () {
                let post = {
                  contain_id: contain.id,
                  quantity: quantityChanged
                };
                fetch(baseUrl + "changeQuantityOfContain", {
                  method: 'post',
                  body: JSON.stringify(post),
                  /*headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                  }*/
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
        btnCheckout.onclick = function () {
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
