<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ATMOS ADMIN - STORE</title>
</head>
<body>
  <?php
    if ($_SESSION['user']['roles'] !== 'ADMIN') {
      ?>
      <section>
        <img class="header-logo" s3c="../../assets/img/Logos/logoAC2.png" alt="logo">
        <h3>Il semblerait que vous vous soyez perdu...</h3>
        <a href="/">Retourner au site</a>
      </section>
  <?php
    } else {
      ?>
      <section>
        <img class="header-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
        <h1>PANEL ADMIN - STORE</h1>
        
      </section>
  <?php
    }
  ?>
</body>
</html>