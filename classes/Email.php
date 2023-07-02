<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email {

    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->SMTPDebug  = 0;
        //Ahora definimos gmail como servidor que aloja nuestro SMTP
        $mail->Host       = $_ENV['EMAIL_HOST'];
        //El puerto será el 587 ya que usamos encriptación TLS
        $mail->Port       = $_ENV['EMAIL_PORT'];
        //Definmos la seguridad como TLS
        $mail->SMTPSecure = 'tls';
        //Tenemos que usar gmail autenticados, así que esto a TRUE
        $mail->SMTPAuth   = true;
        //Definimos la cuenta que vamos a usar. Dirección completa de la misma
        $mail->Username   = $_ENV['EMAIL_USER'];;
        //Introducimos nuestra contraseña de gmail
        $mail->Password   = $_ENV['EMAIL_PASS'];;
        //Definimos el remitente (dirección y, opcionalmente, nombre)
        $mail->SetFrom('barberiabravo@gmail.com', 'Barbería Bravo');
        //Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
        $mail->AddAddress($this->nombre);

        //Definimos el tema del email
         $mail->Subject = 'Confirma tu Cuenta';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '<html>';
         $contenido .= "<p><strong>Hola " . $this->email .  "</strong> Has Creado tu cuenta en App Salón, solo debes confirmarla presionando el siguiente enlace</p>";
         $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";        
         $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
         $contenido .= '</html>';
         $mail->Body = $contenido;

         //Enviar el mail
         $mail->send();

    }

    public function enviarInstrucciones() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        //Ahora definimos gmail como servidor que aloja nuestro SMTP
        $mail->Host       = $_ENV['EMAIL_HOST'];
        //El puerto será el 587 ya que usamos encriptación TLS
        $mail->Port       = $_ENV['EMAIL_PORT'];
        //Definmos la seguridad como TLS
        $mail->SMTPSecure = 'tls';
        //Tenemos que usar gmail autenticados, así que esto a TRUE
        $mail->SMTPAuth   = true;
        //Definimos la cuenta que vamos a usar. Dirección completa de la misma
        $mail->Username   = $_ENV['EMAIL_USER'];
        //Introducimos nuestra contraseña de gmail
        $mail->Password   = $_ENV['EMAIL_PASS'];
        //Definimos el remitente (dirección y, opcionalmente, nombre)
        $mail->SetFrom('bravojhostin232001@gmail.com', 'Jhostin Bravo');
        //Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
        $mail->AddAddress($this->email, 'El Destinatario');
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer Password</a>";        
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }
}