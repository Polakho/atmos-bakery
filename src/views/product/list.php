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
                  <button onClick="addModal(' . $product->getId() . ')">Ajouter au panier</button>
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
        $this->frontController->footer();
        ?>
    </section>
</body>
<script>
    let currentPage = document.querySelector("#page-nbr").textContent
    let btnNext = document.querySelector("#btn-next")
    let btnPrev = document.querySelector("#btn-prev")
    let totalPages = document.querySelector(".listing").getAttribute("data-pages")
    //console.log(totalPages)

    function visibleBtn() {
        let currentPage = document.querySelector("#page-nbr").textContent
        // console.log(currentPage)
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
            console.log(value.getAttribute("data-page"))
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

    function addModal(pId) {

    }

    function cartExist({
        pId,
        pQuantity
    }, uId) {
        if () {
            addCart({
                pId,
                pQuantity
            }, uId, cId)
        } else {
            const panier = await createCart(uId)
            if (panier) {
                addCart({
                    pId,
                    pQuantity
                }, uId, cId)
            }
        }
    }

    function createCart(uId) {

    }
</script>

</html>