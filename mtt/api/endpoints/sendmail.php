<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$subject = 'MailTemplateTester Testmail ('.date("Y-m-d / H:i:s").')';

$validRequest = false;
if(array_key_exists('filename', $_POST) && array_key_exists('email', $_POST)){
    $filename = $_POST['filename'];
    $email = $_POST['email'];
    $validRequest = true;
} elseif(array_key_exists('filename', $_GET) && array_key_exists('email', $_GET)){
    $filename = $_GET['filename'];
    $email = $_GET['email'];
    $validRequest = true;
}

// cancel request if no 'filename' and 'email' given
if(!$validRequest){die();}


require_once '../../classes/Mtt.php';
require_once '../../../config.php';
$mtt = new Mtt();


// sanitize & validate given email address
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mtt->sendJsonResponse(
        $success = false,
        $errormessage = 'e-mail address seems invalid'
    );
}






$html = $mtt->getHtml($filename);
if(!$html){
    $mtt->sendJsonResponse(
        $success = false,
        $errormessage = 'File '.$filename.' not found'
    );
}

// check if html contains html some html specific elements
$extendHtml = $html;
if(!str_contains($html,'<body') && !str_contains($html,'<html')){
   $html_start = '<html>
                        <head>
                            <meta charset="UTF-8">
                        </head>
                        <body>';
   $html_end = '        </body>
                    </html>';
    $extendHtml = $html_start.$extendHtml.$html_end;
}

// Mailing method PHP
if(MAIL_METHOD == 'php'){
    $to = $email;
    $headers  = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message = $extendHtml;
    if(mail($to, $subject, $message, $headers)){
        $mtt->sendJsonResponse(
            $success = true
        );
    };
    die();
}

// Mailing method SMTP
if(MAIL_METHOD == 'smtp'){
    require '../../classes/PHPMailer/Exception.php';
    require '../../classes/PHPMailer/PHPMailer.php';
    require '../../classes/PHPMailer/SMTP.php';
    $mail = new PHPMailer(true);
    try {
        $mail->IsHTML(true);
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = SMTP_AUTH;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->Port       = SMTP_PORT;
        if(SMTP_TLS){
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }
        $mail->setFrom($email, 'MTT');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $html; // not $extendHtml, PHPMailer wants just the body!
        $mail->send();
        $mtt->sendJsonResponse(
            $success = true
        );
    } catch (Exception $e) {
        $mtt->sendJsonResponse(
            $success = true,
            $errormessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        );
    }

}



