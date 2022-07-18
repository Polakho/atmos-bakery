<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>ATMOS ADMIN - STORE</title>
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
      <a href="/admin"><img class="store-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo"></a>
        <h1 class="store-title">GESTION DE MAGASIN</h1>
      </div>

      <div class="store-add-wrapper">
        <h3>Liste des boutiques :</h3>

          <button class="btn btn-primary crud-btn"><a href="/admin/addStore" class="text-crud">Ajouter une boutique</a></button>
          <div class="overflowauto">
            <?php
             //var_dump($stores);
              if (isset($stores)) {
                ?>
                <form method="POST" enctype="multipart/form-data">
                  <table class="table store-crud-table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php
                  foreach ($stores as $store) {
                  ?>
                    <tr>
                      <th scope="row"><?= $store['id'] ?></td>
                      <td><?= $store['name'] ?></td>
                      <td><?= $store['phone'] ?></td>
                      <td><?= $store['address'] ?></td>
                      <td><?= $store['description'] ?></td>
                      <?php
                      if (!isset($store['image']) || $store['image'] == null) {
                      ?>
                        <td><img src="../../assets/img/Logos/logoAC2.png" alt="<?= $store['name'] ?>" class="store-img" style="width: 50px;"></td>
                      <?php
                      } else {
                        // var_dump($store['image']);
                      ?>
                        <td><img src="<?= $store['image'] ?>" alt="<?= $store['name'] ?>" class="store-img" style="width: 50px;"></td>
                      <?php
                      }
                      ?>
                      <td>
                        <button class="btn btn-primary crud-btn"><a href="/admin/updateStore?updateid=<?= $store['id'] ?>" class="text-crud">Modifier</a></button>
                        <button class="btn btn-danger crud-btn"><a href="/admin/deleteStore?deleteid=<?= $store['id'] ?>" class="text-crud">Supprimer</a></button>
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