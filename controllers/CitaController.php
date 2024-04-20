<?php 
     
namespace Controllers;

use MVC\Router;

class CitaController{


    public static function index (Router  $router){

        session_start();
        $nombre = $_SESSION["nombre"];
        



        $router->render('cita/index', [
            'titulo'=> 'AppSalon Citas',
            'nombre'  => $nombre
        ]);

    }
}