<?php 
     
namespace Model;

class Servicio extends ActiveRecord{

    //Base de datos

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'activo'];

    public $id;
    public $nombre;
    public $precio;
    public $activo;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? 0.0;
        $this->activo = $args['activo'] ?? 1;
    }

    public static function consultarPrecio($id){
        $precio = Servicio::consultarSQL("SELECT precio FROM " . self::$tabla . " WHERE id = '" . $id ."'");

        return array_shift($precio);
    }
}