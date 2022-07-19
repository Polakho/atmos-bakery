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
            $user = $UserModel->getUserFromMailAndPassword($_POST['mail'], $_POST['password']);
            if (isset($user['id']) && isset($user['name']) && isset($user['f_name']) && isset($user['mail']) && isset($user['roles'])) {
                $_SESSION['user'] = $user;
                header('Location: /');
                // $this->frontController->redirect('/');
            } else {
                $errorMsg = "Wrong login and/or password.";
                include '../src/views/login/login.php';
                // $this->frontController->redirect('/login');
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
        if (isset($_SESSION['checkout_session'])) {
            unset($_SESSION['checkout_session']);
        }
        unset($_SESSION['user']);
        header('Location: /');
    }



    /**
     * Register un nouveau user (et le connecte)
     */
    public function register()
    {
        $userModel = new UserModel();
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
                $user = $userModel->CreateNewUser($_POST['name'], $_POST['f_name'], $_POST['mail'], $_POST['password'], "CLIENT");
                $_SESSION['user'] = $user;
                header("Refresh:0; Url=/");
                include('../src/views/home/home.php');
            }
        } else {
            include '../src/views/register/register.php';
        }
    }
}
