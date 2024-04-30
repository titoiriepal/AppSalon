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

    public static function getDates(){
        $citas = Cita::consultarSQL("SELECT DISTINCT(fecha) FROM " . self::$tabla . " ORDER BY fecha");
        $fechas = [];
        foreach ($citas as $fecha){
            $fechas[] = $fecha->fecha;
        }
        return $fechas;
    }

    public static function getFreeHours($fecha){
        $dias = [];
        $ultimoDia = date("Y-m-d",strtotime($fecha."+ 10 days"));
        $primerDia = date("Y-m-d",strtotime($fecha."- 10 days"));
        if($primerDia <=  date('Y-m-d')){
            $primerDia = date("Y-m-d",strtotime((date('Y-m-d'))."+ 1 days"));
        }
        $citas = Cita::consultarSQL("SELECT * FROM " . self::$tabla . " WHERE fecha >= '" . $primerDia . "' AND fecha <= '" . $ultimoDia . "' ORDER BY fecha");
        $arrayFechas = createArray($citas,$primerDia, $ultimoDia);
        return $arrayFechas;
    }

}