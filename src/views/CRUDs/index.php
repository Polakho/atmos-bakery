<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ATMOS ADMIN</title>
</head>

<body>

  <?php
  if ($_SESSION['user']['roles'] !== 'ADMIN') {
  ?>
    <section>
      <img class="header-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
      <h3>Il semblerait que vous vous soyez perdu...</h3>
      <a href="/">Retourner au site</a>
    </section>
  <?php
  } else {
  ?>
    <section>
      <img class="header-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
      <h1>PANEL ADMIN</h1>
      <div class="admin-list-wrapper">
        <ul>
          <li><a href="/admin/store">Gestion de magasin</a></li>
        </ul>
      </div>
      <div class="admin-list-wrapper" style="margin-top: 10px">
        <ul>
          <li><a href="/admin/user">Gestion des utilisateurs</a></li>
        </ul>
      </div>
      <div class="admin-list-wrapper" style="margin-top: 10px">
        <ul>
          <li><a href="/admin/products">Gestion des produits</a></li>
        </ul>
      </div>
    </section>
  <?php
  }
  ?>
</body>

</html>