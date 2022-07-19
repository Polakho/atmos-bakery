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
 *    description="The best API"
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

    public function doc()
    {
        require_once "../public/swagger/index.html";
        exit();
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
                /*echo json_encode(
                    [
                        "message" => 'Good login',
                        "user_id" => $userId['id']
                    ]
                );*/
                // Create token header as a JSON string
                $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

                // Create token payload as a JSON string
                $payload = json_encode(['user_id' => $userId['id']]);

                // Encode Header to Base64Url String
                $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

                // Encode Payload to Base64Url String
                $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

                // Create Signature Hash
                $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);

                // Encode Signature to Base64Url String
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

                // Create JWT
                $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

                echo json_encode(
                    [
                        "message" => 'Good login',
                        "user_id" => $userId['id'],
                        "jwtoken" => $jwt
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
            $roles = "CLIENT";
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
                //$_SESSION['userId'] = $userId;
                /*echo json_encode(["user_id" => $userId]);*/
                // Create token header as a JSON string
                $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

                // Create token payload as a JSON string
                $payload = json_encode(['user_id' => $userId]);

                // Encode Header to Base64Url String
                $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

                // Encode Payload to Base64Url String
                $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

                // Create Signature Hash
                $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);

                // Encode Signature to Base64Url String
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

                // Create JWT
                $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
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
     * @OA\Get(
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
    public function getActiveCartForUser()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();
        $cartModel = new cartModel();
        $userId = htmlspecialchars($params['user_id']);
        if (isset($userId)) {
            $cart = $cartModel->getActiveCartForUser($userId);
            if ($cart == false) {
                $cart = $cartModel->createActiveCart($userId);
            }
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
    public function addToCart()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();

        $containModel = new containModel();

        $cartId = htmlspecialchars($params['cart_id']);
        $quantity = htmlspecialchars($params['quantity']);
        $productId = htmlspecialchars($params['product_id']);

        if (isset($cartId) && isset($quantity) && isset($productId)) {
            $contain = $containModel->ajouterContain($quantity, $productId, $cartId);
            if (is_numeric($contain)) {
                echo json_encode([
                    "message" => "bravo tu as réussis !",
                    "contain_id" => $contain
                ]);
            } else {
                echo json_encode([
                    "message" => "Sale merde !",
                    "error" => $contain
                ]);
            }
        }
    }

    /**
     * @OA\Get(
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
     *                   example={"list": {
    {
    "id": "21",
    "cart_id": "2",
    "quantity": "4",
    "trash": 0,
    "product": {
    "id": "5",
    "name": "Barbu du Roussillon",
    "price": "11,30",
    "description": "Pain semi complet au levain naturel et ancienne farine (prix au kilo).",
    "compo": "",
    "trash": false,
    "image": "",
    "weight": "",
    "category_id": "2"
    }
    },
    {
    "id": "22",
    "cart_id": "2",
    "quantity": "25",
    "trash": 0,
    "product": {
    "id": "4",
    "name": "Complet",
    "price": "4,00",
    "description": "Pain complet au levain naturel et faire bio (prix au kilo).",
    "compo": "",
    "trash": false,
    "image": "",
    "weight": "",
    "category_id": "2"
    }
    },
    {
    "id": "23",
    "cart_id": "2",
    "quantity": "4",
    "trash": 0,
    "product": {
    "id": "1",
    "name": "Tradition",
    "price": "1.20",
    "description": "La baguette tradition au levain naturel et farine bio.",
    "compo": "",
    "trash": false,
    "image": "",
    "weight": "",
    "category_id": "2"
    }
    },
    {
    "id": "24",
    "cart_id": "2",
    "quantity": "2",
    "trash": 0,
    "product": {
    "id": "2",
    "name": "Tradi-graine",
    "price": "1,30",
    "description": "Une baguette tradition avec un petit twist.",
    "compo": "",
    "trash": false,
    "image": "",
    "weight": "",
    "category_id": "2"
    }
    }
    }}
     *              )
     *          )
     *      )
     * )
     */
    public function getContainsForCart()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();

        $containModel = new containModel();
        $productModel = new productModel();
        if (isset($params['cart_id'])) {
            $cartId = htmlspecialchars($params['cart_id']);
        }
        if (isset($cartId)) {
            $contains = $containModel->getContainsForCart($cartId);

            if (empty($contains)) {
                echo json_encode(["message" => "the cart is empty."]);
                exit();
            }

            $containWithProduct = array();
            foreach ($contains as $contain) {
                $productId = $contain["product_id"];
                $containWithProduct[] = [
                    "id" => $contain["id"],
                    "cart_id" => $contain["cart_id"],
                    "quantity" => $contain["quantity"],
                    "trash" => $contain["trash"],
                    "product" => $productModel->getProductById($productId)->jsonify()
                ];
            }
            echo json_encode(["list" => $containWithProduct]);
            exit();
        }
    }

    /**
     * @OA\Put(
     *     path="/changeQuantityOfContain",
     *     @OA\Parameter(
     *     name="request",
     *     in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="integer",
     *                property="contain_id",
     *                example="2"
     *            ),
     *            @OA\Property(
     *                type="integer",
     *                property="quantity",
     *                example="1"
     *            )
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Changer la quantité d'un produit du panier.",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="cart"),
     *                   example={"message": "La quantité a été changé"}
     *              )
     *          )
     *      )
     * )
     */
    public function changeQuantityOfContain()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();

        $containModel = new containModel();

        $containId = htmlspecialchars($params['contain_id']);
        $quantity = htmlspecialchars($params['quantity']);

        if (isset($containId) && isset($quantity)) {
            $contain = $containModel->changeQuantityOfContain($containId, $quantity);
            if ($contain == true) {
                echo json_encode(["message" => "La quantité a été changé"]);
            } else {
                echo json_encode([
                    "message" => "Sale merde !",
                    "error" => $contain
                ]);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/deleteContain",
     *     @OA\Parameter(
     *     name="request",
     *     in="header",
     *        @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                type="integer",
     *                property="contain_id",
     *                example="2"
     *            )
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Supprime un produit du panier.",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                   type="string",
     *                   description="cart"),
     *                   example={"message": "Le produit a été supprimé du panier"}
     *              )
     *          )
     *      )
     * )
     */
    public function deleteContain()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();

        $containModel = new containModel();
        $containId = htmlspecialchars($params['contain_id']);

        if (isset($containId)) {
            $containModel->deleteContain($containId);
            echo json_encode(["message" => "Le produit: $containId a bien été supprimé du panier"]);
        }
    }

    public function getUserById()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $params = $this->params();

        $userModel = new UserModel;

        $userId = htmlspecialchars($params['user_id']);

        if (isset($userId)) {
            $user = $userModel->getUserById($userId);

            echo json_encode(["user" => $user->jsonify()]);
            exit();
        } else {
            echo json_encode(["message" => "user_id non spécifié"]);
        }
    }
    public function payment()
    {
        $params = $this->params();
        $this->cartModel = new CartModel();
        $this->containModel = new ContainModel();
        $userId = htmlspecialchars($params['user_id']);
        try {
            //go fetch le contain cart pr userid
            if (isset($userId)) {
                $cart = $this->cartModel->getActiveCartForUser($userId);
                $contains = $this->containModel->getContainsForCart($cart->getId());

                $stripe = new \Stripe\StripeClient(
                    'sk_test_51LMubWEwkB3AlPNOHdSWpQtXjSuqPCZHdxL0dKhMeavcVV4b7VMJfvFJzMsOkSwojslHH55BbQFZAPHXNJ1yfnID00mquLbGul'
                );


                $prices = [];
                $quantities = [];
                $line_items_array = [];
                foreach ($contains as $contain) {
                    $price = $stripe->prices->search([
                        'query' => "product:'" . $contain['product_id'] . "'",
                    ]);

                    $line_items_array[] = [
                        'price' => $price['data'][0]['id'],
                        'quantity' => $contain['quantity']
                    ];
                }
                // var_dump($line_items_array);
                $session = $stripe->checkout->sessions->create([
                    'success_url' => 'http://atmoscorp.xyz:8455/stripe/success',
                    'cancel_url' => 'http://atmoscorp.xyz:8455/stripe/cancel',
                    'line_items' => $line_items_array,
                    'mode' => 'payment',
                ]);
                echo json_encode(["url" => $session['url']]);
            }
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            echo 'Status is:' . $e->getHttpStatus() . '\n';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
        } catch (\Stripe\Exception\RateLimitException $e) {
            echo 'RateLimitException';
            // Too many requests made to the API too quickly
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            echo 'InvalidRequestException:';
            echo 'InvalidRequestException:';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Exception\AuthenticationException $e) {
            echo 'AuthenticationException';
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            echo 'ApiConnectionException';
            // Network communication with Stripe failed
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo 'ApiErrorException';
            // Display a very generic error to the user, and maybe send
            // yourself an email
        }
    }
}
