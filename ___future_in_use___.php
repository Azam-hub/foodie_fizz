// All PHP Future in use

// ---------***----------- Remember to use ""mysqli_real_escape_string()"" ----------***----------

{
    <?php
    
    $escaped_string = mysqli_real_escape_string($conn, $string); // $string is string that want to escape 

    ?>
}

// ------------------------ Config File ------------------------
{
    <?php


    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "foodie_fizz";

    $conn = mysqli_connect($server, $username, $password, $database);

    if (!$conn) {
        echo "Couldnot Connect to database";
    }

    ?>
}


// ------------------------ Messages Styling and Function ------------------------

{
    <style>
    .msg {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        font-size: 16px;
    }

    .msg .left .icon {
        font-size: 26px;
        transform: translateY(3px);
    }

    .msg .right p {
        margin-left: 10px;
        font-size: 17px;
        font-weight: 500;
    }

    .danger-msg {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .success-msg {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .primary-msg {
        color: #084298;
        background-color: #cfe2ff;
        border-color: #b6d4fe;
    }
    </style>

    <?php

        function success_msg($msg) {
            $text = '<div class="msg success-msg">
                        <div class="left">
                            <ion-icon class="icon" name="checkmark-circle-outline"></ion-icon>
                        </div>
                        <div class="right">
                            <p>'.$msg.'</p>
                        </div>
                    </div>';
            return $text;
        }
        function danger_msg($msg) {
            $text = '<div class="msg danger-msg">
                        <div class="left">
                            <ion-icon class="icon" name="alert-circle-outline"></ion-icon>
                        </div>
                        <div class="right">
                            <p>'.$msg.'</p>
                        </div>
                    </div>';
            return $text;
        }
        function primary_msg($msg) {
            $text = '<div class="msg primary-msg">
                        <div class="left">
                            <ion-icon class="icon" name="checkmark-circle-outline"></ion-icon>
                        </div>
                        <div class="right">
                            <p>'.$msg.'</p>
                        </div>
                    </div>';
            return $text;
        }
    ?>
}

// ------------------------ Random Code Generator ------------------------

{
    <?php

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
        echo $code;


    ?>
}

// ------------------------ Mail Sender ------------------------

{
    // 4 lines are commented so first remove comments 
    // composer.json, composer.lock and vendor are available in folder

    <?php
        // First Inculde at top

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'vendor/autoload.php';

        // $mail = new PHPMailer(true);

        // then
        $mail_send = false;

        // try {
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
        // } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // }

    ?>
}

// ------------------------ Date Time Custom Formats ------------------------

{
    <?php
        // All are mixed
        date_default_timezone_set("Asia/Karachi");
        $datetime = date("YnjGis");
        // ------------------------------------------

        date_default_timezone_set("Asia/Karachi");
        $datetime = date("Y-m-d H:i:s"); // Should be added in database like this i.e. "2023-01-29 05:10:48"
        
        $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($datetime)); // retrieving Output: "03:35 pm || 07 Mar, 2023"
    ?>
}

// ------------------------ Password Hashing and Decoding ------------------------

{
    // Hashing Password
    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

    // Check password
    $match_password = password_verify($user_password, $db_password);
}

// ------------------------ Removing Parameters from URL (JS Code) ------------------------

{
    // JS Code

    // Function to remove get parameters from url
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
    }
}

// ------------------------ Ajax call ------------------------

{
    $.ajax({
        url: 'path_to_file',
        type: 'POST/GET',
        data: {
            action: "unban-customer",
            customer_id: customer_id
        },
        success: function (data) {
            if (data == 1) {
                location.reload()
            } else {
                console.log(data);
            }
        }
    })
}

// ------------------------ Images file formats ------------------------

{
    $file_formats = ["jpg", "jpeg", "gif", "png", "tiff", "tif"]
}







// Some CSS Future in use

// --------------------- Statuses and Actions CSS ------------------

{
    // ---------- Statuses -----------

    .status {
        border-radius: 5px;
        font-size: 13px;
        padding: 5px;
        color: #fff;
    }
    .in-progress-status {
        background-color: rgb(245, 160, 4);
        display: inline-block;
        width: 86px;
    }
    .delivered-status {
        background-color: rgb(56, 196, 38);
    }
    .pending-status {
        background-color: rgb(38, 119, 196);
    }
    .removed-status {
        background-color: rgb(196, 38, 51);
        /* background-color: red; */
    }

    // ---------- Actions -----------

    .action {
        padding: 4px 12px;
        border: 2px solid;
        border-radius: 5px;
        cursor: pointer;
        outline: none;
        color: #fff;
        font-size: 15px;
        margin: 4px auto;
        display: block;
    }
    .in-progress-action {
        background-color: #0069d9;
        border-color: #015ab9;
    } 
    .remove-action {
        background-color: #e22639;
        border-color: #bd2130;
    }
    .deliver-action {
        background-color: #29c523;
        border-color: #0c9100;
    }

}



// Some JS Future in use

// -------------------- To hide list accept clickon itself --------------------------

{
    $('body').click(function(evt){
        if(evt.target.classList.contains('list') || evt.target.classList.contains('show_hide_list_btn')) {
            return;
            
        }
        if($(evt.target).closest('.list, .show_hide_list_btn').length) {
            return;             
        }
        $('.select-box .list').hide()
    });
}

// --------------------- Take URL Parameters in JS ---------------------

{
    let parameter = (window.location.href).split('?')[1];
    var type;
    if (parameter) {
        type = (parameter.split('='))[1]
    } else {
        type = 'all';
    }
}