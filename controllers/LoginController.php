<?php 
     
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        

        $router->render('auth/login',[
            'titulo' => 'App Salon Login'
        ]);
    }

    public static function logout(){
        echo "Desde Logout";
    }

    public static function olvide(Router $router) {


        $router->render('auth/olvide',[
            'titulo' => 'App Salon Recuperar Password'
        ]);
    }

    public static function recuperar(){
        echo "Desde Recuperar password";
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
        $usuario = array_shift(Usuario::where('token', $token));
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