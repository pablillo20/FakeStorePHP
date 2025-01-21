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
}
