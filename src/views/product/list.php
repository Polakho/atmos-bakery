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
    let modalState = false;
    let modal = document.querySelector('.modal-add-product');
    function showModal() {
        modalState = !modalState;
        if (modalState == false) {
            modal.classList.add("hidden")
        } else {
            modal.classList.remove("hidden")
        }
    }

    let AllBtnAdd = document.querySelectorAll(".add-product")
    AllBtnAdd.forEach(function (btn, index){
        btn.addEventListener("click", function () {
            showModal()
        })
    })
</script>

</html>