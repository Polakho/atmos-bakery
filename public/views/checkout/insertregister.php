<?php

use App\Autoloader;
use App\Classes\Users;

require "src/classes/Autoloader.php";
Autoloader::register();

$username = "";
$errors   = array();
if(isset($_POST['submit'])){
    register();
}
$user = new Users();
function register()
{
    require_once "config.php";
    // call these variables with the global keyword to make them available in function
    global $dbs, $errors, $user, $pass;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username = $_POST['name'];
    $mail = $_POST['email'];
    $password_1 = $_POST['password'];
    $password_2 = $_POST['cpassword'];
    echo "$username \n";
    echo "$mail \n";
    echo "$password_1\n";
    echo "$password_2\n";
    $verif = $user ->verify();
    var_dump($verif);
    while ($row = $verif->fetch()) {
        $usernamedb = $row[1];
        if ($_POST['name'] == $usernamedb) {
            echo $username;
            array_push($errors, "Username aleready exist");
        }

        // form validation: ensure that the form is correctly filled
        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password_1)) {
            array_push($errors, "Password is required");
        }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
        }
        var_dump($errors);
        // register user if there are no errors in the form
        if (count($errors) == 0) {
            $password = md5($password_1);//encrypt the password before saving in the database
            $sql = "INSERT INTO user_info(`name`,`email`,`password` ) VALUES (:name,:mail,:password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":name" => $username,
                ":mail" => $mail,
                ":password" => $password,
            ]);

        }
    }
}
function e($val){
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}
function getUserById($id){
    global $db;
    $query = $db->prepare('SELECT * FROM table WHERE id=:id');
//using bindParam helps prevent SQL Injection
    $query->bindParam(':id', $_SESSION['user_id']);
    $query->execute();
//$results is now an associative array with the result
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}
