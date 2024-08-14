<?php

use function PHPSTORM_META\map;

require "../../_config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../mail_sender/vendor/autoload.php';
$mail = new PHPMailer(true);

if (isset($_POST['action'])) {
    
    // Getting email from database
    $get_sql = "SELECT * FROM `admin_panel_credential` WHERE `id` = '1'";
    $get_res = mysqli_query($conn, $get_sql);
    $data = mysqli_fetch_assoc($get_res);
    $email = $data['email'];
    
    // Generating random code
    function random_code_generator($length){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
    $code = random_code_generator(50);
    

    // Sending mail
    $mail_send = false;
    try {
        $mail->SMTPDebug = 0;                                       
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                             
        $mail->Username   = $from_email_address;                 
        $mail->Password   = $from_email_address_password;                        
        $mail->SMTPSecure = 'tls';                              
        $mail->Port       = 587;  
    
        $mail->setFrom($from_email_address, 'Foodie Fizz');         // Sender address and name
        $mail->addAddress($email, "Admin");                               // Receiver address and name
        
        $mail->isHTML(true);                                  
        $mail->Subject = 'Verification Link';                            // Message Subject
        $mail->Body    = 'Dear <b><q>Admin</q></b><br>This is your Password Reset link <br>
        <a href="'.$domain_name.'admin_panel/change_password.php?code='.$code.'" target="_blank" style="text-decoration: none; padding: 5px 15px; border: 1px solid rgb(155, 64, 4); border-radius: 6px; background-color: #fa7c14; color: #fff; font-size: 16px; font-weight: 500; outline: none; margin-top: 14px; display: inline-block;">
        Click here to Reset
        </a>
        ';    // Message Body
        $mail->send();
        $mail_send = true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    if ($mail_send) {
        // Updating database
        $update_sql = "UPDATE `admin_panel_credential` SET `code` = '$code' WHERE `id` = '1'";
        $update_res = mysqli_query($conn, $update_sql);
    
        if ($update_res) {
            echo 1;
        } else {
            echo 0;
        }
        
    } else {
        echo 0;
    }
    

}


?>