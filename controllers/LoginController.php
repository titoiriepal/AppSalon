<?php 
     
namespace Controllers;

class LoginController{

    public static function login(){
        echo "Desde Login";
    }

    public static function logout(){
        echo "Desde Logout";
    }

    public static function olvide(){
        echo "Desde Olvide mi password";
    }

    public static function recuperar(){
        echo "Desde Recuperar password";
    }

    public static function crear(){
        echo "Desde crear Cuenta";
    }
}