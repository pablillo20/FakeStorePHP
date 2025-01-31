<?php

namespace Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PhpMail
{
    public function enviarCorreo(string $correo, string $asunto, string $mensaje, string $pdfContent)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL'];
            $mail->Password = $_ENV['PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom($_ENV['EMAIL'], 'Tienda');
            $mail->addAddress($correo);

            $mail->Subject = $asunto;
            $mail->msgHTML($mensaje);

            // Adjuntar PDF
            $mail->addStringAttachment($pdfContent, 'datosDelPedido.pdf', 'base64', 'application/pdf');

            $mail->send();
        } catch (Exception $e) {
            error_log('Error al enviar correo: ' . $mail->ErrorInfo);
        }
    }

    public function enviarToken(string $correo, string $nombre, string $token)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL'];
            $mail->Password = $_ENV['PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom($_ENV['EMAIL'], 'Tienda');
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $contenido = '<html>';
            $contenido .= '<p><strong>Hola ' . $nombre  . '</strong>: Has Creado tu cuenta en Buenayantar.com, solo debes confirmarla presionando el siguiente enlace</p>';
            $contenido .= '<p>Presiona aquí: <a href="http://localhost/Tienda/confirmarCuenta/' . $token . '">Confirmar Cuenta</a></p>';
            $contenido .= '<p>Si no solicitaste este cambio, puedes ignorar el mensaje</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;


            $mail->send();
        } catch (Exception $e) {
            error_log('Error al enviar correo: ' . $mail->ErrorInfo);
        }
    }
}
