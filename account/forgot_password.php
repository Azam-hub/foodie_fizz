<?php

require "../_config.php";
date_default_timezone_set("Asia/Karachi");

session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    header("location: ../index.php");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../mail_sender/vendor/autoload.php';
$mail = new PHPMailer(true);

$msg = "";

if (isset($_POST['submit'])) {
    // Getting Fields Input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Checking fields are filled or not
    if ($email == "") {
        $msg = danger_msg("Please enter your Email address.");
    } else {

        // Get customers rows to check duplication of emails
        $get_email_sql = "SELECT * FROM `customers` WHERE `email` = '$email'";
        $get_email_res = mysqli_query($conn, $get_email_sql);
        $get_email_rows = mysqli_num_rows($get_email_res);

        // Checking duplication of emails
        if ($get_email_rows != 1) {
            $msg = danger_msg("Wrong Email address <b><q>".$email."</q></b>!");
        } else {

            // Getting name from fetched rows
            $get_email_data = mysqli_fetch_assoc($get_email_res);
            $name = $get_email_data['name'];

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

            // Send code on email 
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
                $mail->addAddress($email, $name);                               // Receiver address and name
                
                $mail->isHTML(true);                                  
                $mail->Subject = 'Reset Password Link';                            // Message Subject
                $mail->Body    = 'Dear <b><q>'.$name.'</q></b><br>This is your reset password link <br>
                <a href="'.$domain_name.'account/change_password.php?code='.$code.'" target="_blank" style="text-decoration: none; padding: 5px 15px; border: 1px solid rgb(155, 64, 4); border-radius: 6px; background-color: #fa7c14; color: #fff; font-size: 16px; font-weight: 500; outline: none; margin-top: 14px; display: inline-block;">
                Click here to Reset Password
                </a>
                ';    // Message Body
                $mail->send();
                $mail_send = true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // Check mail send or not
            if ($mail_send) {

                // Updating code
                $update_sql = "UPDATE `customers` SET `code` = '$code' WHERE `email` = '$email'";
                $update_res = mysqli_query($conn, $update_sql);

                if ($update_res) {
                    $msg = success_msg("A Reset Password link has been sent on your Email address <b><q>".$email."</q></b>.");
                } else {
                    $msg = danger_msg("Something went wrong! Please try again later.");
                }
                
            } else {
                $msg = danger_msg("Mail couldn't send. Please try again later.");
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password - Foodie Fizz</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Pattaya&family=Racing+Sans+One&display=swap" rel="stylesheet">

    <!-- Fontawesome Link -->
    <link rel="stylesheet" href="../fontawesome_icon/css/all.min.css">

    <!-- Local Links -->
    <link rel="shortcut icon" href="../img/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/_utils.css">
    <link rel="stylesheet" href="../css/_header_footer.css">
    <link rel="stylesheet" href="../css/_form.css">
    
    <link rel="stylesheet" href="../css/account/forgot_password.css">
</head>
<body>

<div class="head-main-container">
    <?php include "_header.php"; ?>
    <?php echo $msg; ?>
    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Forgot Password</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="left">
                <form class="proper-form" method="POST">
                    <div class="email">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email">
                    </div>
                    <div class="form-sections btn">
                        <button type="submit" class="submit-btn" name="submit">Send Reset Link</button>
                        <img src="../img/loading.gif" class="loading-gif" alt="Loading GIF">
                    </div>
                </form>
                <p class="jump">Go back to <a href="login.php">Login</a></p>
            </div>
            <div class="right">
                <img src="../img/account/forgot_password_pic.jfif" alt="">
            </div>
        </div>
    </section>
    <?php include "_footer.php"; ?>

</div>
    
</body>

<!-- jQuery -->
<script src="../jquery/jquery-3.6.1.min.js"></script>

<script>
    $('.submit-btn').click(function () {
        $('.loading-gif').show()
    })
</script>

<!-- Header Footer Js -->
<script src="../js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>