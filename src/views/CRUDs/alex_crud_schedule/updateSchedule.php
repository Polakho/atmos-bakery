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
            <a href="/admin/schedule"><img class="store-logo" src="../../assets/img/Logos/logoAC2.png" alt="logo"></a>
            <a href="/admin/schedule"><h1 class="store-title">GESTION DE L'HORAIRE</h1></a>
        </div>
        <div class="schedule-edit">
            <div class="edit-info">
                <h3>Modification des horaires :</h3>
                <?php
                foreach($schedules as $schedule){
                    $day = $schedule->getDay();
                    echo "<div class='jour' data-jour='".$day."'>";
                    echo "<h5>";

                    switch ($day) {
                        case 1:
                            echo "Lundi";
                            break;
                        case 2:
                            echo "Mardi";
                            break;
                        case 3:
                            echo "Mercredi";
                            break;
                        case 4:
                            echo "Jeudi";
                            break;
                        case 5:
                            echo "Vendredi";
                            break;
                        case 6:
                            echo "Samedi";
                            break;
                        case 7:
                            echo "Dimanche";
                            break;
                    }


                    echo "</h5>
                                  <div class='horraires'>
                                    <div class='moitie'>";
                    echo 'Matin :
                                <input class="opAm" type="time" value="';
                    if($schedule->getOpAm() != null){
                        echo date("H:i", strtotime($schedule->getOpAm()));
                    }
                    echo '"> à 
                                <input class="clAm" type="time" value="';
                    if($schedule->getClAm() != null){
                        echo date("H:i", strtotime($schedule->getClAm()));
                    }
                    echo '">';

                    echo "</div>
                                      <span class='vertical'></span>
                                      <div class='moitie'>";
                    echo 'Après-midi :
                                <input class="opPm" type="time" value="';
                    if($schedule->getOpPm() != null){
                        echo date("H:i", strtotime($schedule->getOpPm()));
                    }
                    echo '"> à 
                                <input class="clPm" type="time" value="';
                    if($schedule->getClPm() != null){
                        echo date("H:i", strtotime($schedule->getClPm()));
                    }
                    echo '">';
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";


                }?>
            </div>
            <button  class="btn btn-primary update-schedule">Modifier</button>
            <button class="btn btn-danger"><a href="/admin/deleteSchedule?deleteid=<?=$store['id']?>" class="text-crud">Supprimer</a></button>

        </div>
    </div>
    <?php
}
?>
</body>
<script>
    let btn = document.querySelector(".update-schedule")
    let semaine = {};
    let jours = document.querySelectorAll(".jour")
    btn.addEventListener("click", function(){
        jours.forEach(function (jour){
            let day = jour.getAttribute("data-jour")

            semaine[day] = {
                "opAm": jour.querySelector(".opAm").value,
                "clAm": jour.querySelector(".clAm").value,
                "opPm": jour.querySelector(".opPm").value,
                "clPm": jour.querySelector(".clPm").value
            };

        })
        let post = {
            "session" : <?= json_encode($_SESSION) ?>,
            semaine,
            storeId : <?= $id ?>
        }
        fetch(/*baseUrl + */"http://atmos:8888/admin/updatingSchedules", {
            method: 'post',
            body: JSON.stringify(post),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        }).then((response) => {

            return response
        }).then((res) => {
            console.log(res)
            location.reload()
        }).catch((error) => {
            console.log(error);
        });
    })
</script>
</html>
