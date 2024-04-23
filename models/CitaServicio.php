<?php 
     
namespace Model;

class CitaServicio extends ActiveRecord{

    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'citaId', 'servicioId', 'precio'];

    public $id;
    public $citaId;
    public $servicioId;
    public  $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId= $args['servicioId'] ?? '';
        $this->precio = $args['precio'] ?? 0;
    }
}