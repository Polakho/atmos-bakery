<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ATMOS ADMIN - STORE</title>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <style>
        <?php include './css/global.css'; ?>
    </style>
</head>
<body>
<?php
if ($_SESSION['user']['roles'] !== 'ADMIN') {
    ?>
    <section>
        <img class="store-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo">
        <h3>Il semblerait que vous vous soyez perdu...</h3>
        <a href="/">Retourner au site</a>
    </section>
    <?php
} else {
    ?>
    <div class="store-page">
        <div class="store-head-wrapper">
            <a href="/admin"><img class="store-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo"></a>
            <h1 class="store-title">GESTION DES HORAIRES</h1>
        </div>

        <div class="store-add-wrapper">
            <h3>Liste des boutiques :</h3>

            <div class="overflowauto">
                <?php
                if (isset($stores)) {
                    ?>
                    <form method="POST" enctype="multipart/form-data">
                        <table class="table store-crud-table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
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
                                    <td>
                                        <?php
                                        if ($scheduleModel->isRenseigner($store['id']) == true){
                                            echo '<button class="btn btn-primary crud-btn"><a href="/admin/updateSchedule?updateid='.$store['id'].'" class="text-crud">Modifier</a></button>';
                                            echo  '<button class="btn btn-danger crud-btn"><a href="/admin/deleteSchedule?deleteid='.$store['id'].'" class="text-crud">Supprimer</a></button>';

                                        }elseif ($scheduleModel->isRenseigner($store['id']) == false){
                                            echo '<button class="btn btn-primary crud-btn"><a href="/admin/addSchedule?addid='.$store['id'].'" class="text-crud">Ajouter</a></button>';
                                        }
                                        ?>
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
