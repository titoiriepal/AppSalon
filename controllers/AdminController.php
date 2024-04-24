<?php 
     
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{

    public static function index(Router $router){

        session_start();
        isAuth();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $validarFecha = explode('-',$fecha);

        if(!checkdate($validarFecha[1], $validarFecha[2], $validarFecha[0])){
            $fecha = date('Y-m-d');
        }

        //Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'title'=> 'Administrador de App Salon',
            'nombre' =>  $_SESSION['nombre'],
            'citas' =>  $citas,
            'fecha' =>  $fecha
        ]);
    }
}