<?php 
     
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);
            //Validamos los campos del formulario
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                //Buscamos  al usuario en la base de datos
                $usuario = Usuario::where('email', $auth->email);
                if(empty($usuario)){ //Si no existe el usario...
                    Usuario::setAlerta('error', 'El email no corresponde con ningún usuario');
                    $alertas = Usuario::getAlertas(); 
                }else{//Si existe el usario validamos su contraseña y que ya esté confirmado
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){//autentificamos al usuario
                        session_start();
                        $_SESSION = [];
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre .' '. $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] =  true;

                        //REDIRECCIONAMIENTO
                        if($usuario->admin){
                            $_SESSION['admin'] = true;
                            header('location:/admin');
                        }else{
                            header('location:/cita');
                        }
                    }else{
                        Usuario::setAlerta('error', 'El password no es correcto o el usuario no está confirmado o activo');
                    }          
                }
            }   
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'titulo' => 'App Salon Login',
            'alertas' =>  $alertas
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];
        header('location: /');
    
    }

    public static function olvide(Router $router) {

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if(empty($usuario)){ //Si no existe el usario...
                    Usuario::setAlerta('error', 'El email no corresponde con ningún usuario');
                    $alertas = Usuario::getAlertas(); 
                }else{
                    if(!$usuario->comprobarVerificado()){
                        Usuario::setAlerta('error', 'El usuario no esta confirmado o no está activo');
                        $alertas = Usuario::getAlertas(); 
                    }else{
                        //Generamos un toke
                        $usuario->generarToken();
                        $usuario->guardar();

                        //Enviamos un correo para recuperar la contraseña
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarInstrucciones();

                        //Alertas
                        Usuario::setAlerta('exito', 'Te enviamos un correo a tu mail para recuperar la contraseña');
                        $alertas = Usuario::getAlertas(); 
                    }
                }

            }
        }

        $router->render('auth/olvide',[
            'titulo' => 'App Salon Recuperar Password',
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;
        $token   = s($_GET['token']) ??  '';
        $usuario = Usuario::where('token', $token);

        if (empty($usuario) || !$usuario->activo){
            Usuario::setAlerta('error', 'El token proporcionado no es valido'); 
            $error = true;
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                if($_POST['password'] != $_POST['confirma']){
                    Usuario::setAlerta('error','Las contraseñas introducidas no coinciden.');
                }else{
                    
                    $usuario->password = $password->password;
                    $usuario->hashPassword();
                    $usuario->token = null;
                    if($usuario->guardar()){
                        header('location: /');
                    }
                }
            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar',[
            'titulo' => 'App Salon Reestablecer Contraseña',
            'alertas' => $alertas,
            'error' => $error

        ]);
    }

    public static function crear(Router $router){

        $usuario = new Usuario;
        $alertas = $usuario->getAlertas() ?? [];
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar();

            if(empty($alertas)){
                $existeUsuario = $usuario->existeUsuario();
                if(!empty($existeUsuario)){
                    $alertas = Usuario::getAlertas();
                }else{
                    //Hashear el password
                    $usuario->hashPassword();

                    //Generar un token único
                    $usuario->generarToken();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }
                
                }
            }
            
            
        }
        
        $router->render('auth/crear',[
            'titulo' => 'App Salon Crear Cuenta',
            'usuario'  => $usuario,
            'alertas'  => $alertas
        ]);
    }

    public static function confirmar(Router $router) {

        $alertas = [];
        $token   = s($_GET['token']) ??  '';
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)){
            Usuario::setAlerta('error', 'El token proporcionado no es valido'); 
        }else{
            $usuario->confirmado = 1;
            $usuario->token = null;
            $resultado = $usuario->guardar();
            if ($resultado){
                Usuario::setAlerta('exito', 'Usuario confirmado correctamente'); 
            }else{
                Usuario::setAlerta('error', 'Error en el proceso de confirmación'); 
            }
        }
        

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar',[
            'titulo' => 'App Salon Cuenta confirmada',
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje',[
            'titulo' => 'App Salon Cuenta creada'
        ]);
    }
}