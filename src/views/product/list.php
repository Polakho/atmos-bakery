<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/product/list.css">
    <title>Atmos Bakery</title>
</head>

<body>
    <?php
    $this->frontController->header();
    ?>
    <section class="main-section-background">
        <h1 class="titre">Nos Produits</h1>
        <div class="listing" data-pages="<?= $pages ?>">
            <?php
            require("../vendor/autoload.php");

            foreach ($list as $key => $array) {
                echo '<div class="page" data-page="page-' . ($key + 1) . '">';
                /** @var \App\Classes\Product $product */
                foreach ($array as $product) {
                    echo '<div class="card">
                  <img src="' . $product->getImage() . '" 
                  alt="Image Produit" style="width:200px; height:auto">
                  <h1>' . $product->getName() . '</h1>
                  <p class="price">' . $product->getPrice() . ' $</p>
                  <p>' . $product->getDescription() . '</p>
                  <button class="add-product" data-product-id="'. $product->getId() .'">+</button>
                  </div>';
                }
                echo '</div>';
            }
            ?>
            <div id="navigation">
                <button id="btn-prev">Prev</button>
                <p id="page-nbr">1</p>
                <button id="btn-next">Next</button>
            </div>

        </div>
    </section>
    <section>
        <?php
        include "../src/components/modales/addProductModal.php";

        $this->frontController->footer();
        ?>
    </section>
</body>
<script>
    let currentPage = document.querySelector("#page-nbr").textContent
    let btnNext = document.querySelector("#btn-next")
    let btnPrev = document.querySelector("#btn-prev")
    let totalPages = document.querySelector(".listing").getAttribute("data-pages")

    function visibleBtn() {
        let currentPage = document.querySelector("#page-nbr").textContent
        if (currentPage == 1) {
            btnPrev.style.visibility = "hidden";
        } else {
            btnPrev.style.visibility = "visible";
        }
        if (currentPage == totalPages) {
            btnNext.style.visibility = "hidden";
        } else {
            btnNext.style.visibility = "visible";
        }
    }
    visibleBtn()

    function changePage(number) {
        let pages = document.querySelectorAll("*[data-page^=\"page-\"]")
        pages.forEach((value, key) => {
            if (value.getAttribute("data-page") != ("page-" + number)) {
                value.classList.add("hidden")
            } else {
                value.classList.remove("hidden")
            }
        })
    }

    changePage(currentPage)

    btnNext.addEventListener("click", function() {
        if (currentPage < totalPages) {
            currentPage++;
            document.querySelector("#page-nbr").innerHTML = (currentPage)
            changePage(currentPage)
            visibleBtn()
        }
    })

    btnPrev.addEventListener("click", function() {
        if (currentPage > 1) {
            currentPage--;
            document.querySelector("#page-nbr").innerHTML = (currentPage)
            changePage(currentPage)
            visibleBtn()
        }
    })
</script>
<script>
    let currentQuantity = document.querySelector("#product-quantity").textContent
    let btnMore = document.querySelector("#btn-more")
    let btnLess = document.querySelector("#btn-less")

    function visibleBtnQuantity() {
        if (currentQuantity == 1) {
            btnLess.style.visibility = "hidden";
        } else {
            btnLess.style.visibility = "visible";
        }
    }

    visibleBtnQuantity()

    btnMore.addEventListener("click", function() {
            currentQuantity++;
            document.querySelector("#product-quantity").innerHTML = (currentQuantity)
            visibleBtnQuantity()
    })

    btnLess.addEventListener("click", function() {
        if (currentQuantity > 1) {
            currentQuantity--;
            document.querySelector("#product-quantity").innerHTML = (currentQuantity)
            visibleBtnQuantity()
        }
    })
</script>
<script>
    let modalState = false;
    let modal = document.querySelector('.modal-add-product');
    let modalHeader = document.querySelector('.modal-add-product .modal-header');
    function clearBox(elementClass) {
        var div = document.getElementById(elementClass);

        while(div.firstChild) {
            div.removeChild(div.firstChild);
        }
        div.removeAttribute("data-product-id")
    }
    function showModal() {
        modalState = !modalState;
        if (modalState == false) {
            modal.classList.add("hidden")
            clearBox('.modal-add-product .modal-header')
        } else {
            modal.classList.remove("hidden")
        }
    }

    let AllBtnAdd = document.querySelectorAll(".add-product")

    AllBtnAdd.forEach(function (btn, index){
        btn.addEventListener("click", function () {
            showModal()
            let product_id = btn.getAttribute("data-product-id")
            let post = {
                product_id : product_id,

            }
            fetch("http://atmos:8888/api/getProductById", {
                method: 'post',
                body: JSON.stringify(post),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            }).then((response) => {
                return response.json()
            }).then((res) => {
                console.log(res)
                modalHeader.textContent = res.name
                modalHeader.setAttribute("data-product-id", product_id)
            }).catch((error) => {
                console.log(error)
            })
        })
    })


    let cart = document.querySelector(".data-cart")
    let btnAddProduct = document.querySelector(".add-product-action")
    let quantity = document.querySelector("#product-quantity").textContent
    btnAddProduct.addEventListener("click", function (){
        let product_id = modalHeader.getAttribute("data-product-id")
        let post = {
            product_id : product_id,
            cart_id : cart.getAttribute("data-cart-id"),
            quantity : quantity
        }
        console.log(quantity)
        fetch("http://atmos:8888/api/addToCart", {
            method: 'post',
            body: JSON.stringify(post),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        }).then((response) => {
            return response.json()
        }).then((res) => {
            console.log(res)
        }).catch((error) => {
            console.log(error)
        })
    })
</script>

</html>