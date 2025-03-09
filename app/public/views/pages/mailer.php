<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../../vendor/autoload.php"; 

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Username = "minudenisa29@gmail.com";
    $mail->Password = "efys xfvw vtpx sriu"; 

    $mail->isHTML(true);
    $mail->setFrom("minudenisa29@gmail.com", "Haarlem Festival");

    return $mail; 
} catch (Exception $e) {
    die("Mailer error: " . $mail->ErrorInfo);
}
?>
