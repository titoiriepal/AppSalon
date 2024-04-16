<?php 
     
namespace Controllers;

use MVC\Router;

class LoginController{

    public static function login(Router $router){
        

        $router->render('auth/login',[
            'titulo' => 'App Salon Login'
        ]);
    }

    public static function logout(){
        echo "Desde Logout";
    }

    public static function olvide(Router $router) {


        $router->render('auth/olvide',[
            'titulo' => 'App Salon Recuperar Password'
        ]);
    }

    public static function recuperar(){
        echo "Desde Recuperar password";
    }

    public static function crear(Router $router){
        
        
        $router->render('auth/crear',[
            'titulo' => 'App Salon Crear Cuenta'
        ]);
    }
}