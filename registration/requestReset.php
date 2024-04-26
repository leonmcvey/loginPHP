<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";
require_once "generateToken.php";

function sendPasswordResetEmail($email, $resetToken)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.ethereal.email";
        $mail->SMTPAuth = true;
        $mail->Username = 'vinnie.funk81@ethereal.email';
        $mail->Password = 'FdMnw3x9czbjED9pQ4';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom("noreply@stefanssupershop.com", "Password reset");
        $mail->addAddress($email);
        $mail->isHTML(true);

        $mail->Subject = "Password reset";
        $mail->Body = 'Please click the following link to reset your password: <a href="https://example.com/reset_password.php?token=' . $resetToken . '">Reset Password</a>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
