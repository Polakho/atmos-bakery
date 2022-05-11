<?php

use App\Classes\Autoloader;
use App\Models\UserModel;

if (isset($_SESSION['userId'])) {
    unset($_SESSION['userId']);
    header('Location: /');
} else {
    require "../src/models/UserModel.php";
    $UserModel = new UserModel;

    if (isset($_POST['mail']) && isset($_POST['password'])) {
        $userId = $UserModel->GetUserIdFromMailAndPassword($_POST['mail'], $_POST['password']);
        if ($userId > 0) {
            $_SESSION['userId'] = $userId['id'];
            header('Location: /');
        } else {
            $errorMsg = "Wrong login and/or password.";
            include '../src/views/login/login.php';
        }
    } else {
        include '../src/views/login/login.php';
    }
}
