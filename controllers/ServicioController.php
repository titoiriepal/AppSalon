<?php 
     
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{

    public static function index(Router  $router){
       
        session_start();
        isAdmin();

        $servicios = Servicio::all();
        
        


        $router->render( 'servicios/index', [
            'titulo'=>"App Salon Servicios",
            'nombre' =>  $_SESSION['nombre'],
            'servicios' => $servicios

        ]);
    }

    public static function crear(Router  $router){
        session_start();
        isAdmin();

        $servicio = new Servicio();
        $alertas = [];
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();


            if(empty($alertas)){
                $decimal = (round($servicio->precio*100))/100;
                $servicio->precio = $decimal;
                $servicio->guardar();
                header('location: /servicios');
                
            }

        
        }
        $router->render( 'servicios/crear', [
            'titulo'=>"App Salon Crear Servicio",
            'nombre' =>  $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router  $router){
        session_start();
        isAdmin();

        if(!isset($_GET['id'])  ||  !is_numeric($_GET['id'])){
            header( 'Location:/servicios' );
        }

        $servicio = Servicio::find($_GET['id']);
        if(!$servicio){
            header( 'Location:/servicios' );
        }

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio->sincronizar( $_POST );
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        
        $router->render( 'servicios/actualizar', [
            'titulo'=>"App Salon actualizar servicio",
            'nombre' =>  $_SESSION['nombre'],
            'servicio' =>  $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        
        session_start();
        isAdmin();

        if(!isset($_POST['id'])  ||  !is_numeric($_POST['id'])){
            header( 'Location:/servicios' );
        }

        $servicio = Servicio::find($_POST['id']);
        if(!$servicio){
            header( 'Location:/servicios' );
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio = Servicio::find($_POST[ 'id' ]);
            if ($servicio->activo === '1'){
                $servicio->desactivar();
            }else{
                $servicio->activar();
            }
            header("Location: /servicios");
        }
        
    }

}