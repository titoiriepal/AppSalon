<?php 
     
namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;
use Model\Usuario;

class ApiController{

    public static function index(){

        $servicios = Servicio::allActive();
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($servicios, JSON_PRETTY_PRINT);

    }

    public static function guardar(){
         $minutos = ['00','15', '30', '45'];
         
        //Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $citaMinutos = substr($cita->hora, 3, 2);
        if(!in_array($citaMinutos, $minutos)){
            $respuesta = ['error' => 'Horario de cita no valido' ];
             header("Content-type: application/json; charset=utf-8");
             echo json_encode($respuesta, JSON_PRETTY_PRINT);
             return;
        }

        $usuario = Usuario::find($cita->usuarioId);
        if(!$usuario || $usuario->activo === '0'){
            $respuesta = ['error' => 'Usuario no valido' ];
             header("Content-type: application/json; charset=utf-8");
             echo json_encode($respuesta, JSON_PRETTY_PRINT);
             return;
        }
        $existeCita = array_shift($cita->comprobarCita());
         if($existeCita){
             $respuesta = ['error' => 'Horario y día escogidos ya no están disponibles' ];
             header("Content-type: application/json; charset=utf-8");
             echo json_encode($respuesta, JSON_PRETTY_PRINT);
             return;
         }

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


        header("Content-type: application/json; charset=utf-8");
        echo json_encode($respuesta, JSON_PRETTY_PRINT);
    }

    public static function fechas(){
        $fechas = Cita::getDates();
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($fechas);
    }

    public static function horas(){
        $arrayHoras = Cita::getFreeHours($_POST['fecha']);
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($arrayHoras);
    }

    public static function eliminar(){

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->desactivar();

            header('Location: '. $_SERVER['HTTP_REFERER']);
        }
    }
}