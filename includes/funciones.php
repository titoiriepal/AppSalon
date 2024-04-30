<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Revisar que el usario ha iniciado sesion

function isAuth() : void{
    if (!isset($_SESSION['login'])) {
        header( "Location: /" ); 
    }
}

function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header("Location:/");
    }

}

function createArray($citas, $primerDia, $ultimoDia){

    while ($primerDia !=  $ultimoDia) {
        $array[$primerDia] = [];
        $primerDia = date("Y-m-d",strtotime($primerDia."+ 1 days"));
    }
    foreach ($citas as $cita){
        $array[$cita->fecha][]= $cita->hora;
    }

    return  $array;
}