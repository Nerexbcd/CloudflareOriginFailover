<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Config/mail.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'].'/Lib/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'].'/Lib/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/Lib/PHPMailer/src/SMTP.php';

function sendMail($from,$name_from,$to,$name_to,$subject,$content) {
    try {
    $phpmailer = new PHPMailer(true);
    $phpmailer->isSMTP();
    $phpmailer->Host = MAIL_SERVER;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = MAIL_PORT;
    $phpmailer->Username = MAIL_USERNAME;
    $phpmailer->Password = MAIL_PASSWORD;
    $phpmailer->setFrom($from, $name_from);
    $phpmailer->addAddress($to, $name_to);
    $phpmailer->isHTML(true);
    $phpmailer->Subject = $subject;
    $phpmailer->Body    = $content;
    $phpmailer->send();

    // echo 'Message has been sent';
} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
    exit();
}
}

?>