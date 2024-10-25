<?php
require '../vendor/autoload.php'; // Ruta al archivo autoload.php generado por Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // La clase PHPMailer ahora se inicializa con `true`

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->SMTPDebug = 2; // Activa la depuración
    $mail->Host = 'smtp.gmail.com'; // Cambia esto por el servidor SMTP que uses
    $mail->SMTPAuth = true;
    $mail->Username = 'jumancamilo@gmail.com'; // Tu dirección de correo
    $mail->Password = 'fvzphqvdvorxxtom'; // Tu contraseña de correo
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    echo 'Error al enviar el mensaje: ', $mail->ErrorInfo;


    // Remitente y destinatario
    $mail->setFrom('jumancamilo@gmail.com', 'Tu Nombre');
    $mail->addAddress('juantellez@kreaftware.com', 'Nombre del Destinatario');

    // Contenido del mensaje
    $mail->Subject = 'Alerta';
    $mail->Body    = 'Prueba de envio al corroe electronico. ';

    // Enviar el mensaje
    $mail->send();
    echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    echo 'Error al enviar el mensaje: ', $mail->ErrorInfo;
}
?>
