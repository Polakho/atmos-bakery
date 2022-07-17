<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>ATMOS ADMIN - AJOUT STORE</title>
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

        <form action="/admin/addingStore" method="POST" enctype="multipart/form-data">
          <div class="row">

            <div class="col">
              <label>Nom</label>
              <input class="form-control" type="text" name="name" required>
            </div>

            <div class="col">
              <label>Téléphone</label>
              <input class="form-control" type="tel" pattern="[0-9]{10}" name="phone" required>
            </div>
          </div>

          <div class="form-group">
            <label>Adresse</label>
            <input class="form-control" type="text" name="address" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" type="text" rows="3" name="description" required></textarea>
          </div>

          <div class="form-group">
            <label>Photo de la boutique</label>
            <input type="file" class="form-control-file" name="image" id="image">
          </div>

          <button type="submit" class="btn btn-primary" value="Upload Image/Data">Ajouter la boutique</button>
        </form>

      </div>

    </div>
  <?php
  }
  ?>
</body>

</html>