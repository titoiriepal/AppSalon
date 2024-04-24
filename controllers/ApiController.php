<?php 
     
namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class ApiController{
    public static function index(){

    $servicios = Servicio::allActive();
    echo json_encode($servicios);

    }


    public static function guardar(){
        
        //Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $respuesta =  $cita->guardar();

        //Almacena los servicios de la cita

        $idServicios = explode("," , $_POST["servicios"]);

        //Almacena los servicios con el id de la cita y el precio  del servicio correspondiente.

         foreach($idServicios as $idServicio){
             $servicio = Servicio::consultarPrecio($idServicio);
             $args = [
                 'citaId' => $respuesta['id'],
                 'servicioId' =>  $idServicio,
                 'precio' => $servicio->precio
             ];

             $citaServicio = new CitaServicio($args);
             $citaServicio->guardar();
         }



        echo json_encode($respuesta);
    }

    public static function fechas(){
        $fechas = Cita::getDates();
        echo json_encode($fechas);
    }
}