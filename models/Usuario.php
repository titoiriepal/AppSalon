<?php 
     
namespace Model;

class Usuario extends ActiveRecord{

    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre','apellido','email','telefono','password', 'admin', 'confirmado', 'token', 'activo'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $admin;
    public $confirmado;
    public $token;
    public $activo;

    public function __construct($args = []) {

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->activo = $args['activo'] ?? 1;

    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'Añade un nombre  para el usuario.';
        }else if( strlen($this->nombre) > 60){
            self::$alertas['error'][] = 'El nombre no debe superar los 60 caracteres';
        }

        if(!$this->apellido){
            self::$alertas['error'][] = 'Debes añadir, al menos, un apellido para el usuario';
        }else if( strlen($this->apellido) > 60){
            self::$alertas['error'][] = 'Los apellidos no pueden superar los 60 caracteres';
        }

        if(!$this->telefono){
            self::$alertas['error'][] = 'Debes añadir un número de teléfono';
        }else if(!preg_match("/^[+0-9]{1}[0-9]{8,14}$/",$this->telefono)){
            self::$alertas['error'][] = "El número de teléfono debe contener 9 caracteres numéricos como mínimo y 14 como máximo. Se permite el prefijo + para indicar el pais ";
        }

        if(!$this->email){
            self::$alertas['error'][] = 'Debes añadir, al menos, un apellido para el usuario';
        }else if( strlen($this->email) > 45){
            self::$alertas['error'][] = 'El email no puede superar los 45 caracteres';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'Introduce un password';
        }else if(strlen($this->password) < 8){
            self::$alertas['error'][]= "La contraseña debe tener al menos 8 carácteres";
        }

        return (self::$alertas);

        
    }

    public function existeUsuario(){
        $existeUsuario = Usuario::consultarSQL("SELECT * FROM " . self::$tabla ." WHERE email = '" . $this->email . "' LIMIT 1");
        if(!empty($existeUsuario)){
            self::$alertas['error'][] = 'Ya existe un usuario  con este email en la base de datos';
        }    

        return $existeUsuario;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function generarToken(){
        $this->token = uniqid();
    }
}