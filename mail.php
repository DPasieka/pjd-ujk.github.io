<?php 
if(isset($_POST['submit'])){
    $to = "E-MAIL NASZEGO KÓLKA"; 
    $from = $_POST['email']; 
    $name = $_POST['name'];

    $message = $name . " " . $name . " napisał:" . "\n\n" . $_POST['message'];
    $message2 = "Twoja wiadomość wysłana do kółka PJD " . $name . "\n\n" . $_POST['message'];

    $headers = "Od:" . $from;
    $headers2 = "Do:" . $to;
    mail($to,$message,$headers);
    mail($from,$message2,$headers2); 
    header('Location: index.php');
    }
?>