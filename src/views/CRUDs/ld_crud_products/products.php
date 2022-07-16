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
            <img class="store-logo" s3c="../../assets/img/Logos/logoAC2.png" alt="logo">
            <h3>Il semblerait que vous vous soyez perdu...</h3>
            <a href="/">Retourner au site</a>
        </section>
    <?php
    } else {
    ?>
        <div class="store-page">
            <div class="store-head-wrapper">
                <img class="store-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
                <h1 class="store-title">GESTION DE PRODUITS</h1>
            </div>

            <div class="store-add-wrapper">
                <h3>Liste des produits :</h3>

                <button class="btn btn-primary crud-btn"><a href="/admin/addProduct" class="text-crud">Ajouter un produit</a></button>
                <div class="overflowauto">
                    <?php
                    // var_dump($stores);
                    if (isset($products)) {
                    ?>
                        <form method="POST" enctype="multipart/form-data">
                            <table class="table store-crud-table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Composition</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Poids</th>
                                        <th scope="col">Catégorie</th>
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
                                            <?php
                                            if (!isset($product['image']) || $product['image'] == null) {
                                            ?>
                                                <td><img src="../../assets/img/Logos/logoAC2.png" alt="<?= $product['name'] ?>" class="store-img" style="width: 50px;"></td>
                                            <?php
                                            } else {
                                                // var_dump($store['image'][0]['image']);
                                            ?>
                                                <form class="" action="#" method="post">
                                                    <td>
                                                        <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;" />
                                                        <input type="image" id="image" alt="Product image" title="Cliquez pour changer d'image" class="store-img" style="width: 50px" src="<?= $product['image'] ?>" onclick="document.getElementById('fileToUpload').click();">
                                                    </td>
                                                </form>
                                            <?php
                                            }
                                            ?>
                                            <td>
                                                <button class="btn btn-primary crud-btn"><a href="/admin/updateProduct?updateid=<?= $product['id'] ?>" class="text-crud">Modifier</a></button>
                                                <button class="btn btn-danger crud-btn"><a href="/admin/updateProduct?deleteid=<?= $product['id'] ?>" class="text-crud">Supprimer</a></button>
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