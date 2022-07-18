// GESTION DES PAGES
let currentPage = document.querySelector("#page-nbr").textContent;
let btnNext = document.querySelector("#btn-next");
let btnPrev = document.querySelector("#btn-prev");
let totalPages = document.querySelector(".listing").getAttribute("data-pages");

function visibleBtn() {
  let currentPage = document.querySelector("#page-nbr").textContent;
  if (currentPage == 1) {
    btnPrev.style.visibility = "hidden";
  } else {
    btnPrev.style.visibility = "visible";
  }
  if (currentPage == totalPages) {
    btnNext.style.visibility = "hidden";
  } else {
    btnNext.style.visibility = "visible";
  };
};
visibleBtn();

function changePage(number) {
  let pages = document.querySelectorAll("*[data-page^=\"page-\"]");
  pages.forEach((value, key) => {
    if (value.getAttribute("data-page") != ("page-" + number)) {
      value.classList.add("hidden");
    } else {
      value.classList.remove("hidden");
    };
  });
};
changePage(currentPage);

btnNext.addEventListener("click", function() {
  if (currentPage < totalPages) {
    currentPage++;
    document.querySelector("#page-nbr").innerHTML = (currentPage);
    changePage(currentPage);
    visibleBtn();
  };
});

btnPrev.addEventListener("click", function() {
  if (currentPage > 1) {
    currentPage--;
    document.querySelector("#page-nbr").innerHTML = (currentPage);
    changePage(currentPage);
    visibleBtn();
  };
});

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
