<?php 

require '../class/Message.php';
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

if (!$message->MessageValid()) {
    //echo 'Mensagem não é válida';
    header('Location:../index.php');
    //die();
    
}
else {

    //exemplo do site

    //Load Composer's autoloader
    //require '../../../phpMyAdmin/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    require 'credenciais.php'; //usado para puxar o objeto "login" 
                               //credenciais.php está oculto para esconder os dados pessoais

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Disable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $login->emailRemetente;                 //SMTP username
        $mail->Password   = $login->senha;                          //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($login->emailRemetente, 'Mateus');
        $mail->addAddress($message->__get('destiny'), 'Destinatário');     //Add a recipient
        //$mail->addAddress('ellen@example.com');                          //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $message->__get('subject');
        $mail->Body    = $message->__get('message');
        $mail->AltBody = 'Não há suporte à HTML para exibir a mensagem';

        $mail->send();
        
        //armazenando dados do envio
        $message->status['cod_status'] = 1;
        $message->status['description_status'] = 'email enviado com sucesso';
        
    } catch (Exception $e) {
        
        //armazenando dados do envio
        $message->status['cod_status'] = 2;
        $message->status['description_status'] = 'falha ao enviar email. Detalhes do erro: ' . $mail->ErrorInfo;
    }
}

?>

<!-- Posteriormente vou separar esses arquivos -->

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>App Send Mail</title>
</head>

<body>

    <div class="container">

        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-2" src="../img/logo.png" alt="" width="72" height="72">
            <h2>Send Mail</h2>
            <p class="lead">Seu app de envio de e-mails particular!</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php 
                
                if($message->status['cod_status'] == 1) { ?>

                <div class="container">
                    <h1 class="display-4 text-success">Sucesso</h1>
                    <p>Email enviado com sucesso</p>
                    <a href="../index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                </div>

                <?php }

                else { ?>

                <div class="container">
                    <h1 class="display-4 text-danger">Ops!</h1>
                    <p>Falha ao enviar Email</p>
                    <a href="../index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>
                </div>

                <?php }?>


            </div>
        </div>

    </div>

</body>

</html>