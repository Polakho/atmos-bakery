<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Controllers\FrontController;
use App\Models\CartModel;
use App\Models\ContainModel;
use App\Models\ProductModel;
use Stripe\StripeClient;

class Stripe extends Controller
{
    public function __construct()
    {
    }

    public function list()
    {
        $stripe = new \Stripe\StripeClient("sk_test_51LLlADJy770A5I8J7lDo3OQyX49eRgOyJCcdUSNsih2r9acDam3gfCEjiEEwadM3h3dJazEfwPUZRY9tOevhgPeK00pSa2a2aU");
        try {
            $stripe->products->all(['limit' => 3]);
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

    public function create($name)
    {
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
}
