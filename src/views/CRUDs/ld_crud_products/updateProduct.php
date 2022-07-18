<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ATMOS ADMIN - PRODUCT</title>
</head>

<body>
    <?php
    if ($_SESSION['user']['roles'] !== 'ADMIN') {

    ?>
        <section>
            <img class="product-logo" s3c="../../assets/img/Logos/logoAC2.png" alt="logo">
            <h3>Il semblerait que vous vous soyez perdu...</h3>
            <a href="/">Retourner au site</a>
        </section>
    <?php
    } else {
        $categories = $productModel->getCategories();
    ?>
        <div class="product-page">
            <div class="product-head-wrapper">
                <a href="/admin"><img class="product-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo"></a>
                <a href="/admin/products">
                    <h1 class="product-title">GESTION DE PRODUITS</h1>
                </a>
            </div>

            <div class="product-edit-wrapper">

                <div class="product-edit edit-info">
                    <h3>Modification des informations :</h3>
                    <form action="/admin/updatingProduct?id=<?= $product['id'] ?>" method="POST">

                        <div class="row">

                            <div class="col">
                                <label>Nom</label>
                                <input class="form-control" type="text" name="name" value="<?= $product['name']; ?>" required>
                            </div>

                            <div class="col">
                                <label>Prix</label>
                                <input class="form-control" type="text" name="price" value="<?php echo $product['price']; ?>" required>
                            </div>

                            <div class="col">
                                <label>Poids</label>
                                <input class="form-control" type="text" name="weight" value="<?php echo $product['weight']; ?>" required>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col">
                                <label>URL Image</label>
                                <input class="form-control" type="text" name="image" value="<?php echo $product['image']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input class="form-control" type="text" name="description" value="<?php echo $product['description']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Composition</label>
                            <textarea class="form-control" name="compo" rows="3"><?php echo $product['compo']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Catégorie</label>
                            <select class="form-control" name="category"><?php echo $product['category_id']; ?>
                                <?php
                                foreach ($categories as $key => $category) {
                                    if ($key === $product['category_id']) {
                                ?>
                                        <option value="<?= $key ?>" selected><?= $category ?></option>

                                    <?php
                                    }
                                    ?>
                                    <option value="<?= $key ?>"><?= $category ?></option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>

                        <button type="submit" class="btn btn-primary">Modifier les informations</button>
                    </form>
                </div>

                <div class="product-display">
                    <h3>Photo du produit</h3>
                    <?php
                    if (isset($product['image']) && $product['image'] !== '') {
                    ?>
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <?php
                    }
                    ?>
                </div>

            </div>

        </div>
    <?php
    }
    ?>
</body>

</html>