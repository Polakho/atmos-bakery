<?php

use App\Classes\Autoloader;
use App\Models\UserModel;

include '../src/models/UserModel.php';

$userModel = new UserModel();

if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['retypePassword'])) {
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
    $userId = $userModel->CreateNewUser($_POST['name'], $_POST['mail'], $_POST['password']);
    $_SESSION['userId'] = $userId;
    header('Location: /');
  }
} else {
  include '../src/views/register/register.php';
}
