<?php
// First Inculde at top

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

// then
$mail_send = false;

try {
    $mail->SMTPDebug = 0;                                       
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                             
    $mail->Username   = 'legendhacker422@gmail.com';                 
    $mail->Password   = 'lhepuvryfehrnfql';                        
    $mail->SMTPSecure = 'tls';                              
    $mail->Port       = 587;  
  
    $mail->setFrom('legendhacker422@gmail.com', 'Company');         // Sender address and name
    $mail->addAddress($email, $name);                               // Receiver address and name
       
    $mail->isHTML(true);                                  
    $mail->Subject = 'OTP Verification';                            // Message Subject
    $mail->Body    = 'Dear <b>'.$name.'<br>This is your verification code </b><b>'. $dbCode .'</b>';    // Message Body
    $mail->send();
    $mail_send = true;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>