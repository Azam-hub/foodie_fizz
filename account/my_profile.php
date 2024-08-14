<?php

require "../_config.php";
date_default_timezone_set("Asia/Karachi");

// Checking if user logged in or not 
session_start();
if (!(isset($_SESSION['user_logged_in'])) || $_SESSION['user_logged_in'] == false) {
    header("location: ../index.php");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../mail_sender/vendor/autoload.php';
$mail = new PHPMailer(true);

$msg = "";

// Retriving infos from database for showing
$customer_id = $_SESSION['customer_id'];
$get_info_sql = "SELECT * FROM `customers` WHERE `customer_id` = '$customer_id'";
$get_info_res = mysqli_query($conn, $get_info_sql);
$get_info_data = mysqli_fetch_assoc($get_info_res);
$db_name = $get_info_data['name'];
$db_email = $get_info_data['email'];
$db_phone = $get_info_data['mobile_no'];

// Listen submission for name
if (isset($_POST['submit-name'])) {
    // Getting Fields input 
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Updating Info
    $update_sql = "UPDATE `customers` SET `name` = '$name' WHERE `customer_id` = '$customer_id'";
    $update_res = mysqli_query($conn, $update_sql);

    if ($update_res) {
        // $msg = success_msg("Your name ");
        $_SESSION['name'] = $name;
        header("location: my_profile.php");
    } else {
        $msg = danger_msg("Somthing went wrong! Please try again later.");
        
    }
}

// Listen submission for email
if (isset($_POST['submit-email'])) {
    // Getting Fields input 
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $get_email_sql = "SELECT * FROM `customers` WHERE `email` = '$email'";
    $get_email_res = mysqli_query($conn, $get_email_sql);
    $get_email_rows = mysqli_num_rows($get_email_res);

    // Checking duplication of emails
    if ($get_email_rows > 0) {
        $msg = danger_msg("This Email address <b><q>".$email."</q></b> has already been registered.");
    } else {
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

        // Sending code on email address
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
            $mail->addAddress($email, $db_name);                               // Receiver address and name
            
            $mail->isHTML(true);                                  
            $mail->Subject = 'Verification Link';                            // Message Subject
            $mail->Body    = 'Dear <b><q>'.$db_name.'</q></b><br>This is your verification link <br>
            <a href="'.$domain_name.'account/login.php?code='.$code.'&email='.$email.'&action=email_verification" target="_blank" style="text-decoration: none; padding: 5px 15px; border: 1px solid rgb(155, 64, 4); border-radius: 6px; background-color: #fa7c14; color: #fff; font-size: 16px; font-weight: 500; outline: none; margin-top: 14px; display: inline-block;">
            Click here to Verify
            </a>
            ';    // Message Body
            $mail->send();
            $mail_send = true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Check mail send or not
        if ($mail_send) {

            // Updating data inserting code in database
            $update_sql = "UPDATE `customers` SET `code` = '$code' WHERE `customer_id` = '$customer_id'";
            $update_res = mysqli_query($conn, $update_sql);

            if ($update_res) {
                $msg = success_msg("A verification link has been sent on your Email address <b><q>".$email."</q></b>.");
            } else {
                $msg = danger_msg("Somthing went wrong! Please try again later.");
                
            }
            
        } else {
            $msg = danger_msg("Mail couldn't send. Please try again later.");
        }
    }

}

// Listen submission for phone
if (isset($_POST['submit-phone'])) {
    // Getting Fields input 
    $phone = mysqli_real_escape_string($conn, $_POST['mobile_no']);

    // Updating Info
    $update_sql = "UPDATE `customers` SET `mobile_no` = '$phone' WHERE `customer_id` = '$customer_id'";
    $update_res = mysqli_query($conn, $update_sql);

    if ($update_res) {
        // $msg = success_msg("Your name ");
        $_SESSION['phone'] = $phone;
        header("location: my_profile.php");
    } else {
        $msg = danger_msg("Somthing went wrong! Please try again later.");
        
    }
}

// Listen submission for phone
if (isset($_POST['submit-password'])) {
    // Getting Fields input
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Matching old Password
    $db_password = $get_info_data['password'];
    $match = password_verify($old_password, $db_password);

    // Check old is correct or not
    if (!$match) {
        $msg = danger_msg("Incorrect Old Password!");
    } else {
        // Check if password and confirm password are matching or not
        if ($new_password !== $confirm_new_password) {
            $msg = danger_msg("Password and Confirm Password does not match.");            
        } else {
            // Hashing Password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Updating Info
            $update_sql = "UPDATE `customers` SET `password` = '$hashed_password' WHERE `customer_id` = '$customer_id'";
            $update_res = mysqli_query($conn, $update_sql);

            if ($update_res) {
                $msg = success_msg("Your Password has been changed successfully!");
            } else {
                $msg = danger_msg("Somthing went wrong! Please try again later.");
                
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

    <title>My Profile - Foodie Fizz</title>

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
    
    <link rel="stylesheet" href="../css/account/my_profile.css">
</head>
<body>

<div class="head-main-container">


    <div class="black-bg"></div>

    <div class="modal general-modal">
        <i class="fa-solid fa-xmark cross-icon"></i>
        <div class="head"><h1>Update Username</h1></div>
        <form method="POST">
            <div>
                <label for="input-field">Enter your New Username</label>
                <input type="text" placeholder="Enter your New Username" autofocus>
            </div>
            <button>Update</button>
        </form>
    </div>

    <div class="modal password-modal">
        <i class="fa-solid fa-xmark cross-icon"></i>
        <div class="head"><h1>Update Password</h1></div>
        <form method="POST">
            <div>
                <label for="input-field">Enter your Old Password</label>
                <input type="password" name="old_password" placeholder="Old Password" autofocus>
                <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
            </div>
            <div>
                <label for="input-field">Enter your New Password</label>
                <input type="password" name="new_password" placeholder="New Password">
                <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
            </div>
            <div>
                <label for="input-field">Re-enter your New Password</label>
                <input type="password" name="confirm_new_password" placeholder="Re-enter New Password">
                <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
            </div>
            <button name="submit-password">Update</button>
        </form>
    </div>


    <?php include "_header.php"; ?>
    <?php echo $msg; ?>
    
    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>My Profile</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="container">
                <div class="info">
                    <h2 class="head">Your Name</h2>
                    <p class="text"><?php echo $db_name ?></p>
                    <button id="name-btn">Update</button>
                </div>
                <div class="info">
                    <h2 class="head">Your Email</h2>
                    <p class="text"><?php echo $db_email ?></p>
                    <button id="email-btn">Update</button>
                </div>
                <div class="info">
                    <h2 class="head">Your Mobile No.</h2>
                    <p class="text"><?php echo $db_phone ?></p>
                    <button id="mobile-btn">Update</button>
                </div>
                <div class="info">
                    <h2 class="head">Update Password</h2>
                    <button id="password-btn">Change Password</button>
                </div>
                <div class="info">
                    <h2 class="head">Delete your account</h2>
                    <span data-customer-id="<?php echo $_SESSION['customer_id']; ?>" class="delete-account danger-btn">Delete Account</span>
                </div>
            </div>
        </div>
    </section>

    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="../jquery/jquery-3.6.1.min.js"></script>

<script>
    // --------------- Eyes Method ------------------
    $('.open-eye').click(function () {
        $(this).prev().attr('type', "text")
        $(this).hide()
        $(this).next().show()
    })
    $('.close-eye').click(function () {
        $(this).prev().prev().attr('type', "password")
        $(this).hide()
        $(this).prev().show()
    })

    // --------------- Modal Method -----------------
    $(".cross-icon, .black-bg").click(function () {
        $('.black-bg').hide()
        $(".modal").hide()
    })
    $(".container button").click(function () {
        var action = $(this).attr('id')
        var text = $(this).prev().text()

        $('.black-bg').show()
        
        if (action == "name-btn") {
            $(".general-modal").show()
            $(".general-modal form input").focus()

            $(".general-modal h1").text('Update Name')
            $(".general-modal form label").text('Enter your New Name')
            $(".general-modal form input").attr('type', 'text')
            $(".general-modal form input").attr('name', 'name')
            $(".general-modal form input").attr('placeholder', 'Enter your New Name')
            $(".general-modal form input").val(text)
            $(".general-modal form button").attr('name', 'submit-name')
        }
        else if (action == "email-btn") {
            $(".general-modal").show()
            $(".general-modal form input").focus()

            $(".general-modal h1").text('Update Email')
            $(".general-modal form label").text('Enter your New Email')
            $(".general-modal form input").attr('type', 'email')
            $(".general-modal form input").attr('name', 'email')
            $(".general-modal form input").attr('placeholder', 'Enter your New Email')
            $(".general-modal form input").val(text)
            $(".general-modal form button").attr('name', 'submit-email')
        }
        else if (action == "mobile-btn") {
            $(".general-modal").show()
            $(".general-modal form input").focus()

            $(".general-modal h1").text('Update Mobile No.')
            $(".general-modal form label").text('Enter your New Mobile No.')
            $(".general-modal form input").attr('type', 'number')
            $(".general-modal form input").attr('name', 'mobile_no')
            $(".general-modal form input").attr('placeholder', 'Enter your New Mobile No.')
            $(".general-modal form input").val(text)
            $(".general-modal form button").attr('name', 'submit-phone')
        }
        else if (action == "password-btn") {
            $(".password-modal").show()
            $(".password-modal form div:nth-child(1) input").focus()
        }
    })

    // --------------- Deleting Account ---------------
    $(".delete-account").click(function () {
        var customer_id = $(this).data("customer-id");
        

        $.ajax({
            url: "../processors/my_profile/for_delete_account.php",
            type: "POST",
            data: {
                customer_id: customer_id
            },
            success: function (data) {
                if (data == 1) {
                    location.href = "logout.php";
                } else {
                    console.log(data);
                }
            }
        })
    })

</script>

<!-- Header Footer Js -->
<script src="../js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>