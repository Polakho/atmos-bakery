<?php
namespace App\Controllers;

use App\Classes\Controller;
use App\Models\CartModel;
use App\Models\ContainModel;
use App\Models\ProductModel;
use App\Models\UserModel;

use OpenApi\Annotations as OA;


/**
 * @OA\Info(title="Atmose Bakery API", version="1.0.8")
 * @OA\Server(
 *    url="http://atmos/api",
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

    public function doc(){
        require_once "../public/swagger/index.html";
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     @OA\Parameter(
     *     name="request",
     *     in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="string",
     *                property="mail",
     *                example="toto@uyb.fr"
     *            ),
     *            @OA\Property(
     *                type="string",
     *                property="password",
     *                example="monmdp"
     *            ),
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Permet de vérifier les logins transmis",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="user_id"),
     *                   example={"message":"Good login","user_id":"3"}
     *              )
     *          )
     *      )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/register",
     *     @OA\Parameter(
     *     name="request",
     *     in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="string",
     *                property="mail",
     *                example="david@uyb.fr"
     *            ),
     *            @OA\Property(
     *                type="string",
     *                property="password",
     *                example="monmdp"
     *            ),
     *            @OA\Property(
     *                type="string",
     *                property="retypePassword",
     *                example="monmdp"
     *            ),
     *            @OA\Property(
     *                type="string",
     *                property="name",
     *                example="David"
     *            ),
     *            @OA\Property(
     *                type="string",
     *                property="f_name",
     *                example="Mouret"
     *            ),
     *            @OA\Property(
     *                type="string",
     *                property="roles",
     *                example="CLIENT"
     *            ),
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Permet de créer un user et renvoie son id",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="user_id"),
     *                   example={"user_id": "9"}
     *              )
     *          )
     *      )
     * )
     */
    public function register()
    {
        $params = $this->params();
        $userModel = new UserModel();

        $mail = htmlspecialchars($params['mail']);
        $name = htmlspecialchars($params['name']);
        $f_name = htmlspecialchars($params['f_name']);
        $password = htmlspecialchars($params['password']);
        $retypePassword = htmlspecialchars($params['retypePassword']);
        $roles = $params['roles'];

        if (empty($roles)) {
            $roles ="CLIENT";
        }
        if (isset($mail) && isset($name) && isset($f_name) && isset($password) && isset($retypePassword) && isset($roles)) {
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
                $userId = $userModel->CreateNewUser($name, $f_name, $mail, $password, $roles);
                $_SESSION['userId'] = $userId;
                echo json_encode(["user_id" => $userId]);
                exit();
            }
        } else {
            echo json_encode(["message" => 'Pas de paramètres']);
            exit();
        }
    }

    /**
     * @OA\Get(
     *     path="/getAllProducts",
     *     @OA\Response(
     *          response="200",
     *          description="Renvoie la liste des produits.",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="liste"),
     *                   example={{
    "id": "1",
    "name": "Tradition",
    "price": "1.20",
    "description": "La baguette tradition au levain naturel et farine bio.",
    "compo": "",
    "tash": false,
    "image": "",
    "weight": "",
    "category_id": "2"
    },
    {
    "id": "2",
    "name": "Tradi-graine",
    "price": "1,30",
    "description": "Une baguette tradition avec un petit twist.",
    "compo": "",
    "tash": false,
    "image": "",
    "weight": "",
    "category_id": "2"
    }}
     *              )
     *          )
     *      )
     * )
     */
    public function getAllProducts()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        $productModel = new ProductModel();
        echo json_encode($productModel->getAllProductJson());
    }

    /**
     * @OA\Get(
     *     path="/getProductById",
     *      @OA\Parameter(
     *      name="request",
     *      in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="integer",
     *                property="product_id",
     *                example="9"
     *            ),
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Renvoie un produit.",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="product"),
     *                   example={
    "id": "1",
    "name": "Tradition",
    "price": "1.20",
    "description": "La baguette tradition au levain naturel et farine bio.",
    "compo": "",
    "tash": false,
    "image": "",
    "weight": "",
    "category_id": "2"
    }
     *              )
     *          )
     *      )
     * )
     */
    public function getProductById()
    {
        $params = $this->params();

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $productId = htmlspecialchars($params['product_id']);

        $productModel = new ProductModel();

        echo json_encode($productModel->getProductById($productId)->jsonify());
    }

    /**
     * @OA\Post(
     *     path="/getActiveCartForUser",
     *     @OA\Parameter(
     *     name="request",
     *     in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="integer",
     *                property="user_id",
     *                example="2"
     *            ),
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Récupère un panier actif ou renvoie null",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="cart"),
     *                   example={"cart": {"id": "1","user_id": "2","status": "1"}}
     *              )
     *          )
     *      )
     * )
     */
    public function getActiveCartForUser(){
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();
        $cartModel = new cartModel();
        $userId = htmlspecialchars($params['user_id']);
        if (isset($userId)){
            $cart = $cartModel->getActiveCartForUser($userId);
            echo json_encode(["cart" => $cart->jsonify()]);
            exit();
        }

    }

    /**
     * @OA\Post(
     *     path="/addToCart",
     *     @OA\Parameter(
     *     name="request",
     *     in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="integer",
     *                property="cart_id",
     *                example="2"
     *            ),
     *            @OA\Property(
     *                type="integer",
     *                property="quantity",
     *                example="1"
     *            ),
     *            @OA\Property(
     *                type="integer",
     *                property="product_id",
     *                example="34"
     *            ),
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Permet d'ajouter un produit en quantité (ou pas) au panier.",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="cart"),
     *                   example={"message": "bravo tu as réussis !","contain_id": "3"}
     *              )
     *          )
     *      )
     * )
     */
    public function addToCart(){
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();

        $containModel = new containModel();

        $cartId = htmlspecialchars($params['cart_id']);
        $quantity = htmlspecialchars($params['quantity']);
        $productId = htmlspecialchars($params['product_id']);

        if (isset($cartId) && isset($quantity) && isset($productId)){
            $contain = $containModel->ajouterContain($quantity, $productId, $cartId);
            if (is_numeric($contain)){
                echo json_encode(["message" => "bravo tu as réussis !",
                                  "contain_id" => $contain  ]);
            }else{
                echo json_encode(["message" => "Sale merde !",
                                  "error" => $contain  ]);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/getContainsForCart",
     *     @OA\Parameter(
     *     name="request",
     *     in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="integer",
     *                property="cart_id",
     *                example="2"
     *            ),
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Recupère le contenu d'un panier.",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="cart"),
     *                   example={"message": "bravo tu as réussis !","contain_id": "3"}
     *              )
     *          )
     *      )
     * )
     */
    public function getContainsForCart(){
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();

        $containModel = new containModel();
        $productModel = new productModel();

        $cartId = htmlspecialchars($params['cart_id']);

        if (isset($cartId)){
            $contains = $containModel->getContainsForCart($cartId);

            if (empty($contains)){
                echo json_encode(["message" => "the cart is empty."]);
                exit();
            }

            $containWithProduct = array();
            foreach ($contains as $contain){
                $productId = $contain["product_id"];
                $containWithProduct[]=[
                    "id" => $contain["id"],
                    "cart_id" => $contain["cart_id"],
                    "quantity" => $contain["quantity"],
                    "trash" => $contain["trash"],
                    "product" => $productModel->getProductById($productId)->jsonify()
                ];
            }
            echo json_encode(["list" => $containWithProduct]);
        }
    }
}
