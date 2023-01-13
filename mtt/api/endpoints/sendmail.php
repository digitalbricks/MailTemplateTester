<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$subject = 'MailTemplateTester Testmail ('.date("Y-m-d / H:i:s").')';

$validRequest = false;
if(array_key_exists('filename', $_POST)){
    $filename = $_POST['filename'];
    $validRequest = true;
} elseif(array_key_exists('filename', $_GET)){
    $filename = $_GET['filename'];
    $validRequest = true;
}
if(!$validRequest){die();}



require_once '../../classes/Mtt.php';
require_once '../../../config.php';
$mtt = new Mtt();


$html = $mtt->getHtml($filename);
if(!$html){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array(
        'status' => false,
        'error' => 'File '.$filename.' not found'
    ));
    die();
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
    $to = DEFAULT_MAIL_RECEIVER;
    $headers  = "From: " . DEFAULT_MAIL_RECEIVER . "\r\n";
    $headers .= "Reply-To: " . DEFAULT_MAIL_RECEIVER . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message = $extendHtml;
    if(mail($to, $subject, $message, $headers)){
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'status' => true,
            'error' => ''
        ));
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
        $mail->setFrom(DEFAULT_MAIL_RECEIVER, 'MTT');
        $mail->addAddress(DEFAULT_MAIL_RECEIVER);
        $mail->Subject = $subject;
        $mail->Body = $html; // not $extendHtml, PHPMailer wants just the body!
        $mail->send();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'status' => true,
            'error' => ''
        ));
    } catch (Exception $e) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'status' => true,
            'error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        ));
    }

}



