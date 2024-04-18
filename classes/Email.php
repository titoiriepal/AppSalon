<?php 
     
namespace Classes;

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;
    

    public function __construct($email, $nombre, $token){

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    

    public function enviarConfirmacion(){

        $dotenv = Dotenv::createImmutable(__DIR__ .'/..');
        $dotenv->load();
        $mail = new PHPMailer();

        //Configuramos SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = $_SERVER['MAIL_USER'];
        $mail->Password = $_SERVER['MAIL_PWD'];
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('cuentas@appsalon.com'); //Dominio que se cree para la web
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');//Correo electronico y nombre del remitente
        $mail->Subject = 'Confirma tu cuenta de AppSalon';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre  . "</strong> Has creado tu cuenta en Appsalon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .=  "<p>Presiona aquí: <a href='http://localhost:33000/confirmar-cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tú no solicitaste esta cuenta, ignora este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        $mail->send();
 
    }

    public function enviarInstrucciones(){

        $dotenv = Dotenv::createImmutable(__DIR__ .'/..');
        $dotenv->load();
        $mail = new PHPMailer();

        //Configuramos SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = $_SERVER['MAIL_USER'];
        $mail->Password = $_SERVER['MAIL_PWD'];
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('cuentas@appsalon.com'); //Dominio que se cree para la web
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');//Correo electronico y nombre del remitente
        $mail->Subject = 'Restablece tu password para AppSalon';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre  . "</strong> Has solicitado reestablecer tu password. Sigue el siguiente enlace para hacerlo</p>";
        $contenido .=  "<p>Presiona aquí: <a href='http://localhost:33000/recuperar?token=". $this->token ."'>Reestablecer Password</a></p>";
        $contenido .= "<p>Si tú no solicitaste reestablecer tu password, ignora este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        $mail->send();
 
    }

}