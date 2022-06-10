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

    $openapi = \OpenApi\Generator::scan(['./src']);

    header('Content-Type: application/x-yaml');
    echo $openapi->toYaml();
    foreach ($list as $key => $array){
        echo '<div class="page" data-page="page-'.($key+1).'">';
               /** @var \App\Classes\Product $product */
    foreach ($array as $product){
       echo '<div class="card">
                  <img src="https://mapetiteassiette.com/wp-content/uploads/2019/05/shutterstock_553887610-e1557046359887-800x601.jpg" 
                  alt="Image Produit" style="width:200px; height:auto">
                  <h1>'.$product->getName().'</h1>
                  <p class="price">'.$product->getPrice().' $</p>
                  <p>'.$product->getDescription().'</p>
            </div>';
    }
    echo'</div>';
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

    function visibleBtn(){
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

    function changePage(number){
        let pages = document.querySelectorAll("*[data-page^=\"page-\"]")
        pages.forEach((value, key) => {
            console.log(value.getAttribute("data-page"))
            if (value.getAttribute("data-page") != ("page-"+number)){
                value.classList.add("hidden")
            }else{
                value.classList.remove("hidden")
            }
        })
    }

    changePage(currentPage)

    btnNext.addEventListener("click", function (){
        if (currentPage < totalPages) {
            currentPage++;
            document.querySelector("#page-nbr").innerHTML = (currentPage)
            changePage(currentPage)
            visibleBtn()
        }
    })

    btnPrev.addEventListener("click", function (){
        if (currentPage > 1) {
            currentPage--;
            document.querySelector("#page-nbr").innerHTML = (currentPage)
            changePage(currentPage)
            visibleBtn()
        }
    })
</script>
</html>