<?php 
     
namespace Model;

class Cita extends ActiveRecord{

    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuarioId', 'activo'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;
    public $activo;

    function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->activo = $args['activo'] ?? 1;
    }

}