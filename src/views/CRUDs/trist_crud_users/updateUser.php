<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ATMOS ADMIN - USER</title>
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
            <img class="user-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
            <a href="/admin/users"><h1 class="user-title">GESTION DES UTILISATEURS</h1></a>
        </div>

        <div class="user-edit-wrapper">

            <div class="user-edit edit-info">
                <h3>Modification des informations :</h3>
                <form action="/admin/updatingUser?id=<?=$user['id']?>" method="POST">

                    <div class="row">
                        <div class="col">
                            <label>Nom de Famille</label>
                            <input class="form-control" type="text" name="f_name" value="<?php echo $user['f_name']; ?>" required>
                        </div>
                        <div class="col">
                            <label>Nom</label>
                            <input class="form-control" type="text" name="name" value="<?= $user['name']; ?>" required>
                        </div>
                        <div class="col">
                            <label>Mail</label>
                            <input class="form-control" type="email" name="mail" value="<?= $user['mail']; ?>" required>
                        </div>
                    </div>
                    <div class="col,form-control">
                        <label>Actif ?</label>
                        <select class="form-control" style="text-align: center;margin-bottom: 10px" name="trash">
                            <option value="0">Activer</option>
                            <option value="1">Desactiver</option>
                        </select>
                    </div>

                    <div class="col,form-control">
                        <label>Role</label>
                        <select class="form-control" style="text-align: center;margin-bottom: 10px" name="roles">
                            <option value="CLIENT">Client</option>
                            <option value="ADMIN">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier les informations</button>
                </form>
            </div>

        </div>

    </div>
    <?php
}
?>
</body>
</html>