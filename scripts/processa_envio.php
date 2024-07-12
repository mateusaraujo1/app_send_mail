<?php 

require_once '../class/Message.php';
require '../library/PHPMailer/Exception.php';
require '../library/PHPMailer/OAuthTokenProvider.php';
require '../library/PHPMailer/PHPMailer.php';
require '../library/PHPMailer/OAuth.php';
require '../library/PHPMailer/POP3.php';
require '../library/PHPMailer/SMTP.php';



$message = new Message($_POST['destiny'], 
                       $_POST['subject'], 
                       $_POST['message']);

echo '<pre>';
print_r($message);

echo $message->MessageValid();

?>