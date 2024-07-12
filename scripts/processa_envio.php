<?php 

require_once '../class/Message.php';
require '../library/PHPMailer/Exception.php';
require '../library/PHPMailer/OAuthTokenProvider.php';
require '../library/PHPMailer/PHPMailer.php';
require '../library/PHPMailer/OAuth.php';
require '../library/PHPMailer/POP3.php';
require '../library/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer; //utiliza os recursos do namespace PHPMailer
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception; 

$message = new Message($_POST['destiny'], 
                       $_POST['subject'], 
                       $_POST['message']);

echo '<pre>';
print_r($message);
echo '</pre>';


if (!$message->MessageValid()) {
    echo 'Mensagem não é válida';
    die();
    
}
else {

    //exemplo do site

    //Load Composer's autoloader
    //require '../../../phpMyAdmin/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'souza8383328@gmail.com';               //SMTP username
        $mail->Password   = 'tazl cdio czny zmdf';                  //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('souza8383328@gmail.com', 'Remetente');
        $mail->addAddress('f.mateusaraujo2000@gmail.com', 'Destinatário');     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'assunto';
        $mail->Body    = 'mensagem';
        $mail->AltBody = 'mensagem';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
?>