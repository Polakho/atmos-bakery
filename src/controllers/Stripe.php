<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Controllers\FrontController;
use App\Models\CartModel;
use App\Models\ContainModel;
use App\Models\ProductModel;
use Stripe\StripeClient;
use Dotenv\Dotenv;

class Stripe extends Controller
{
    private $dotenv;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->containModel = new ContainModel();
        $this->productModel = new ProductModel();
        $this->dotenv  = Dotenv::createImmutable(__DIR__ . "/../../");
    }


    public function list()
    {
        header('Content-Type: application/json');
        $stripe = new \Stripe\StripeClient("sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU");
        try {
            echo json_decode($stripe->products->all(['limit' => 3]));
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
            var_dump($stripe);
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

    public function create($name)
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN') {
            $stripe = new \Stripe\StripeClient("sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU");
            try {
                $stripe->products->create([
                    'name' => $name,
                ]);
                var_dump($stripe);
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
                var_dump($stripe);
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

    public function retrieve($id)
    {
        $stripe = new \Stripe\StripeClient("sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU");
        try {
            $stripe->products->retrieve(
                $id
            );
            var_dump($stripe);
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
            var_dump($stripe);
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

    public function importAll()
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN') {
            $productModel = new ProductModel;
            $products = $productModel->getAllProductJson();
            $stripe = new \Stripe\StripeClient("sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU");

            foreach ($products as $product) {
                try {
                    $stripe->products->create([
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'description' => $product['description'],
                        'images' => [$product['image']],
                        'metadata' => [
                            'price' => $product['price'],
                            'compo' => $product['compo'],
                            'weight' => $product['weight'],
                            'category_id' => $product['category_id']
                        ]
                    ]);

                    $stripe->prices->create([
                        'unit_amount_decimal' => $product['price'] * 100,
                        'currency' => 'eur',
                        'product' => $product['id'],
                        'metadata' => ['price_value' =>  $product['price']]

                    ]);
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
                    echo 'Type is:' . $e->getError()->type . '\n';
                    echo 'Param is:' . $e->getError()->param . '\n';
                    echo 'Message is:' . $e->getError()->message . '\n';
                    // continue;
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
    }

    public function deleteAllProducts()
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['roles'] === 'ADMIN') {
            $passkey = explode('=', $_SERVER['REQUEST_URI'])[1];
            $this->dotenv->load(); // juste pr pas faire de betise
            $verif = $_ENV["STRIPE_VERIF"];
            if ($verif !== $passkey) {
                header('Location: /');
            }
            $productModel = new ProductModel;
            $products = $productModel->getAllProductJson();
            $stripe = new \Stripe\StripeClient("sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU");
            try {
                foreach ($products as $product) {
                    $stripe->products->delete(
                        $product['id'],
                        []
                    );
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


    public function payment()
    {
        function random_str(
            int $length = 64,
            string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
        ): string {
            if ($length < 1) {
                throw new \RangeException("Length must be a positive integer");
            }
            $pieces = [];
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i = 0; $i < $length; ++$i) {
                $pieces[] = $keyspace[random_int(0, $max)];
            }
            return implode('', $pieces);
        }
        try {
            //go fetch le contain cart pr userid
            if (isset($_SESSION['user'])) {

                $_SESSION['checkout_session'] = random_str();

                $cart = $this->cartModel->getActiveCartForUser($_SESSION['user']['id']);
                $contains = $this->containModel->getContainsForCart($cart->getId());

                $stripe = new \Stripe\StripeClient(
                    'sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU'
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
                    'success_url' => 'http://atmosdev.com/stripe/success?checkoutsess=' . $_SESSION['checkout_session'], //TODO: REMPLACER L'URL
                    'cancel_url' => 'http://atmosdev.com/stripe/cancel?checkoutsess=' . $_SESSION['checkout_session'],
                    'line_items' => $line_items_array,
                    'mode' => 'payment',
                ]);
                var_dump($session);
                // header('Location: ' . $session['url'] . '');
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

    public function success()
    {
        $checkout_session = explode('=', $_SERVER['REQUEST_URI'])[1];

        $stripe = new \Stripe\StripeClient(
            'sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU'
        );
        $stripe->checkout->sessions->retrieve( // Trouver le moyen de recup la session terminee par lutilisateur
            '',
            []
        );
        include('');
    }


    public function cancel()
    {
        $stripe = new \Stripe\StripeClient(
            'sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU'
        );
        $stripe->checkout->sessions->retrieve(
            '',
            []
        );
    }
}
