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

    public function validar() {
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del servicio es obligatorio';
        }else if( strlen($this->nombre) > 60){
            self::$alertas['error'][] = 'El nombre del servicio no debe superar los 60 caracteres';
        }

        if(!$this->precio){
            self::$alertas['error'][] = 'El precio del servicio es obligatorio';
        }else if(!is_numeric($this->precio)){
            self::$alertas['error'][] = 'El precio debe ser un formato numérico';

        }else if( intval($this->precio)>=100000){
            self::$alertas['error'][] = 'El nombre del servicio no debe superar los 99999.99€';
        }

        return (self::$alertas);
    }
}