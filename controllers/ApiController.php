<?php 
     
namespace Controllers;

use Model\Servicio;

class ApiController{
    public static function index(){

    $servicios = Servicio::allActive();
    echo json_encode($servicios);

    }
}