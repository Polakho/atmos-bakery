<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ATMOS ADMIN - AJOUT USER</title>

</head>

<body>
<?php
if ($_SESSION['user']['roles'] !== 'ADMIN') {
    ?>
    <section>
        <img class="user-logo" s3c="../../assets/img/Logos/logoAC2.png" alt="logo">
        <h3>Il semblerait que vous vous soyez perdu...</h3>
        <a href="/">Retourner au site</a>
    </section>
    <?php
} else {
    ?>
    <div class="user-page">
        <div class="user-head-wrapper">
            <a href="/admin"><img class="user-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo"></a>
            <a href="/admin/users"><h1 class="user-title">Création d'un nouvel utilisateur</h1></a>
        </div>

        <div class="user-add-wrapper" style="text-align: center">

            <form action="/admin/createUser" method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="col">
                        <label>Prénom</label>
                        <input class="form-control" type="text" name="name" required>
                    </div>

                    <div class="col">
                        <label>Nom de Famille</label>
                        <input class="form-control" type="text" name="f_name" required>
                    </div>
                </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="mail" required>
                    </div>

                    <div class="form-group">
                        <label>Mot de Passe</label>
                        <input class="form-control" type="password" pattern=".{8,}" name="password" required>
                    </div>

                    <div class="col,form-control">
                        <label>Role</label>
                        <select class="form-control" style="text-align: center;margin-bottom: 10px" name="roles">
                            <option value="CLIENT">Client</option>
                            <option value="ADMIN">Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Crée le nouvel Utilisateur</button>
            </form>

    </div>
    </div>
    <?php
}
?>
</body>

</html>