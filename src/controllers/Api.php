<?php
namespace App\Controllers;

use App\Classes\Controller;
use App\Models\ProductModel;
use App\Models\UserModel;

use OpenApi\Annotations as OA;


/**
 * @OA\Info(title="Atmose Bakery API", version="1.0.0")
 * @OA\Server(
 *    url="http://atmos/api/v1",
 *    description="Superbe API Antoine"
 * )
 */
class Api extends Controller
{
    public function __construct()
    {

    }

    private function params()
    {
        return (json_decode(file_get_contents('php://input'), true));
    }

    public function login()
    {
        $params = $this->params();

        $userModel = new UserModel();
        $mail = htmlspecialchars($params['mail']);
        $password = htmlspecialchars($params['password']);


        if (isset($mail) && isset($password)) {
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');

            $userId = $userModel->GetUserIdFromMailAndPassword($mail, $password);
            if ($userId > 0) {
                echo json_encode(
                    [
                        "message" => 'Good login',
                        "user_id" => $userId['id']
                    ]
                );
                exit();
            } else {
                $errorMsg = "Wrong login and/or password.";

                echo json_encode(["message" => $errorMsg]);
                exit();
            }
        } else {
            echo json_encode(["message" => 'Pas de paramètres']);
            exit();
        }
    }

    public function register()
    {
        $params = $this->params();
        $userModel = new UserModel();

        $mail = htmlspecialchars($params['mail']);
        $name = htmlspecialchars($params['name']);
        $password = htmlspecialchars($params['password']);
        $retypePassword = htmlspecialchars($params['retypePassword']);
        $roles = $params['roles'];

        if (empty($roles)) {
            $roles = [
                "CLIENT"
            ];
        }
        if (isset($mail) && isset($name) && isset($password) && isset($retypePassword) && isset($roles)) {
            header('Content-Type: application/json');
            $errorMsg = NULL;
            if (!$userModel->IsMailAlreadyUsed($mail)) {
                $errorMsg = "Cette adresse mail est déjà utilisée.";
            } else if ($password != $retypePassword) {
                $errorMsg = "Les mots de passe ne sont pas les memes.";
            } else if (strlen(trim($password)) < 8) {
                $errorMsg = "Votre mot de passe doit contenir 8 caractères au minimum.";
            }
            if ($errorMsg) {
                echo json_encode(["message" => $errorMsg]);
                exit();
            } else {
                $userId = $userModel->CreateNewUser($name, $mail, $password, $roles);
                $_SESSION['userId'] = $userId;
                echo json_encode(["userId" => $userId]);
                exit();
            }
        } else {
            echo json_encode(["message" => 'Pas de paramètres']);
            exit();
        }
    }

    public function getAllProducts()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        $productModel = new ProductModel();
        echo json_encode($productModel->getAllProductJson());
    }
}
