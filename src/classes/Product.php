<?php

namespace App;

class Product
{

    private $db;


    public function __construct(){

    }

    public function getAllProduct(){
        $db = new Database();
        $products = $db->query("SELECT * FROM product");

        return $products;
    }
}