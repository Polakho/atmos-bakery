<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\UserModel;
use App\Controllers\FrontController;



class Auth extends Controller
{
    //Pas d'index ici

    public function __construct()
    {
        $this->frontController = new FrontController();
    }

    /**
     * Page de login, connecte le user
     */
    public function login()
    {
        $UserModel = new UserModel();
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

    /**
     * Logout le user en cours
     */
    public function logout()
    {
        unset($_SESSION['userId']);
        header('Location: /');
    }

    /**
     * Register un nouveau user (et le connecte)
     */
    public function register()
    {
         var_dump($_POST['f_name']);
        $userModel = new UserModel();
         var_dump($_POST['f_name']); 
        if (isset($_POST['name']) && isset($_POST['f_name']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['retypePassword'])) {
            $errorMsg = NULL;
            if (!$userModel->IsMailAlreadyUsed($_POST['mail'])) {
                $errorMsg = "Cette adresse mail est déjà utilisée.";
            } else if ($_POST['password'] != $_POST['retypePassword']) {
                $errorMsg = "Les mots de passe ne sont pas les memes.";
            } else if (strlen(trim($_POST['password'])) < 8) {
                $errorMsg = "Votre mot de passe doit contenir 8 caractères au minimum.";
            }
            if ($errorMsg) {
                include '../src/views/register/register.php';
            } else {
                $userId = $userModel->CreateNewUser($_POST['name'], $_POST['f_name'], $_POST['mail'], $_POST['password'], "CLIENT");
                var_dump($userId);
                $_SESSION['userId'] = $userId;
                header('Location: /');
            }
        } else {
            include '../src/views/register/register.php';
        }
    }
}
