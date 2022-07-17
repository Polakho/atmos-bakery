<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ATMOS ADMIN - STORE</title>
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
}else{
?>
<div class="user-page">
    <div class="user-head-wrapper">
        <img class="user-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
        <h1 class="user-title">GESTION DES UTILISATEURS</h1>
    </div>

    <div class="user-add-wrapper">
        <h3>Liste des Utilisateurs :</h3>

        <button class="btn btn-primary crud-btn"><a href="/admin/addUser" class="text-crud">Ajouter un Utilisateur</a>
        </button>
        <div class="overflowauto">
            <?php
            //var_dump($users);
            if (isset($users)) {
            ?>
            <form method="POST" enctype="multipart/form-data">
                <table class="table user-crud-table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Nom de Famille</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actif ?</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php
                    foreach ($users as $user) {
                        //var_dump($user);
                        if($user['trash'] == 1){
                                                ?>
                            <tr class = 'trashed_user'>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['mail'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['f_name'] ?></td>
                            <td><?= $user['roles'] ?></td>
                            <td><?= $user['trash'] ?></td>
                            <td>
                        <button class="btn btn-primary crud-btn"><a
                                    href="/admin/updateUser?updateid=<?= $user['id'] ?>" class="text-crud">Modifier</a>
                        </button>
                        <button class="btn btn-danger crud-btn"><a
                                    href="/admin/deleteUser?deleteid=<?= $user['id'] ?>" class="text-crud">Supprimer</a>
                        </button>
                    </td>
                    </tr>

                      <?php  }else{ ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['mail'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['f_name'] ?></td>
                            <td><?= $user['roles'] ?></td>
                            <td><?= $user['trash'] ?></td>
                            <td>
                                <button class="btn btn-primary crud-btn"><a
                                            href="/admin/updateUser?updateid=<?= $user['id'] ?>" class="text-crud">Modifier</a>
                                </button>
                                <button class="btn btn-danger crud-btn"><a
                                            href="/admin/deleteUser?deleteid=<?= $user['id'] ?>" class="text-crud">Supprimer</a>
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                    }
                    }
                    }
                    ?>

</body>
</html>