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
  if (!isset($_SESSION['user'])) {
  ?>
    <section>
      <img class="header-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
      <h3>Il semblerait que vous vous soyez perdu...</h3>
      <a href="/">Retourner au site</a>
    </section>
  <?php
    exit();
  }
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
      <a href="/">
        <h1>PANEL ADMIN</h1>
      </a>
      <div class="admin-list-wrapper">
        <ul class="list-admin">
          <li class="list-admin-item"><a href="/admin/store">Gestion de magasin</a></li>
          <span class="horizental-crud"></span>
          <li class="list-admin-item"><a href="/admin/products">Gestion des produits</a></li>
          <span class="horizental-crud"></span>
          <li class="list-admin-item"><a href="/admin/schedule">Gestion des horaires</a></li>
          <span class="horizental-crud"></span>
          <li class="list-admin-item"><a href="/admin/users">Gestion des Utilisateurs</a></li>
        </ul>
      </div>
    </section>
  <?php
  }
  ?>
</body>

</html>