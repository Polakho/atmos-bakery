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
            require_once '../src/models/'.$class.'.php';
        } else
            if(strpos($class, "App\Classes") !== false) {
            $class = str_replace("App\\Classes", "", $class);
            $class = str_replace("\\", "/", $class);

            require_once '../src/classes/'.$class.'.php';
        }else
            if(strpos($class, "App\Controllers") !== false){
            $class = str_replace("App\\Controllers", "", $class);
            $class = str_replace("\\", "/", $class);
            require_once '../src/controllers/'.$class.'.php';
        }

    }

}