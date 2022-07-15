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
}else{
?>
<div class="store-page">
    <div class="store-head-wrapper">
        <img class="store-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
        <h1 class="store-title">GESTION DES UTILISATEURS</h1>
    </div>

    <div class="store-add-wrapper">
        <h3>Liste des Utilisateurs :</h3>

        <button class="btn btn-primary crud-btn"><a href="/admin/addStore" class="text-crud">Ajouter un Utilisateur</a></button>
        <div class="overflowauto">
<?php
}
?>

</body>
</html>