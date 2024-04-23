<?php 
     
namespace Controllers;

use MVC\Router;

class CitaController{


    public static function index (Router  $router){

        session_start();

        isAuth();
        $nombre = $_SESSION["nombre"];


        $router->render('cita/index', [
            'titulo'=> 'AppSalon Citas',
            'nombre'  => $nombre,
            'usuarioId' =>  $_SESSION['id']
        ]);

    }
}