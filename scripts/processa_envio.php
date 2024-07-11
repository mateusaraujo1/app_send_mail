<?php 

require_once '../class/Message.php';



$message = new Message($_POST['destiny'], 
                       $_POST['subject'], 
                       $_POST['message']);

echo '<pre>';
print_r($message);

echo $message->MessageValid();

?>