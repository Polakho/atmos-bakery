<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ATMOS ADMIN - PRODUCTS</title>
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
    ?>
        <div class="product-page">
            <div class="product-head-wrapper">
                <a href="/admin"><img class="product-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo"></a>
                <h1 class="product-title">GESTION DES PRODUITS</h1>
            </div>

            <div class="product-add-wrapper">
                <h3>Liste des produits :</h3>

                <button class="btn btn-primary crud-btn"><a href="/admin/addProduct" class="text-crud">Ajouter un produit</a></button>
                <div class="overflowauto">
                    <?php
                    // var_dump($products);
                    if (isset($products)) {
                        $categories = $productModel->getCategories();
                    ?>
                        <form method="POST" enctype="multipart/form-data">
                            <table class="table product-crud-table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Composition</th>
                                        <th scope="col">Poids</th>
                                        <th scope="col">Catégorie</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($products as $product) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $product['id'] ?></td>
                                            <td><?= $product['name'] ?></td>
                                            <td><?= $product['price'] ?></td>
                                            <td><?= $product['description'] ?></td>
                                            <td><?= $product['compo'] ?></td>
                                            <td><?= $product['weight'] ?></td>
                                            <td><?= $categories[$product['category_id']] ?></td>

                                            <?php
                                            if (!isset($product['image']) || $product['image'] == null) {
                                            ?>
                                                <td><img src="../../assets/img/Logos/logoAC2.png" alt="<?= $product['name'] ?>" class="product-img" style="width: 50px;"></td>
                                            <?php
                                            } else {
                                                // var_dump($product['image'][0]['image']);
                                            ?>
                                                <td><img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-img" style="width: 50px;"></td>
                                            <?php
                                            }
                                            ?>
                                            <td>
                                                <button class="btn btn-primary crud-btn"><a href="/admin/updateProduct?updateid=<?= $product['id'] ?>" class="text-crud">Modifier</a></button>
                                                <button class="btn btn-danger crud-btn"><a href="/admin/deleteProduct?deleteid=<?= $product['id'] ?>" class="text-crud">Supprimer</a></button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
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