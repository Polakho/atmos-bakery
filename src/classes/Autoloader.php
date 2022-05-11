<?php

namespace App\Classes;

class Autoloader
{
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class){

        if(strpos($class, "App\Models") !== false){
            $class = str_replace("App\\Models", "", $class);
            $class = str_replace("\\", "/", $class);
            require '../src/models/'.$class.'.php';
        }else{
            $class = str_replace("App\\Classes", "", $class);
            $class = str_replace("\\", "/", $class);

            require '../src/classes/'.$class.'.php';
        }

    }

}