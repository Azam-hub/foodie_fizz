<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
session_start();
$msg = "";

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true && 
( isset($_SESSION['general_logged_in']) || isset($_SESSION['supervisor_logged_in']) )) {
    header("location: index.php");
}

if (isset($_GET['password_changed'])) {
    $msg = success_msg("Your Password has been changed successfully.");
}

if (isset($_POST['submit'])) {
    // Fetching fields input
    $general_password = $_POST['general-password'];
    $supervisor_password = $_POST['supervisor-password'];

    if ($general_password == "") {
        $msg = danger_msg("General password is required.");
    } else {
        // Get data sql
        $get_sql = "SELECT * FROM `admin_panel_credential` WHERE `id` = '1'";
        $get_res = mysqli_query($conn, $get_sql);
        $data = mysqli_fetch_assoc($get_res);
        
        // Check Supervior want to login or not
        if ($supervisor_password === "") {
            
            // Check only general password
            $db_general_password = $data['general_password'];
            $match_general_password = password_verify($general_password, $db_general_password);
    
            // Matching
            if ($match_general_password) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['general_logged_in'] = true;
                header("location: index.php");
            } else {
                $msg = danger_msg("Incorrect General Password");
                
            }
            
        } else {
    
            // Check general and supervisor password
            $db_general_password = $data['general_password'];
            $db_supervisor_password = $data['supervisor_password'];
    
            $match_general_password = password_verify($general_password, $db_general_password);
            $match_supervisor_password = password_verify($supervisor_password, $db_supervisor_password);
    
            // Matching
            if ($match_general_password && $match_supervisor_password) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['supervisor_logged_in'] = true;
                header("location: index.php");
            } else {
                $msg = danger_msg("Incorrect General or Supervisor Password");                
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

    <title>Login - Foodie Fizz</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Pattaya&family=Racing+Sans+One&display=swap" rel="stylesheet">

    <!-- Fontawesome Link -->
    <link rel="stylesheet" href="fontawesome_icon/css/all.min.css">

    <!-- Local Links -->
    <link rel="shortcut icon" href="src/static/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/_utils.css">
    <link rel="stylesheet" href="css/_sidebar_header.css">
    
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<?php echo $msg; ?>
<div class="head-main-container">
    <div class="container">
        <div class="upper-container">
            <!-- <img src="src/static/logo/white_logo.png" alt=""> -->
            <h1>Foodie Fizz</h1>
        </div>
        <div class="downer-container">
            <form method="POST">
                <h3>Login at Admin Panel</h3>
                <div class="general-password-div">
                    <label for="general-password">Password</label>
                    <input type="password" name="general-password" id="general-password" placeholder="Enter your Password" autofocus>
                    <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                    <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                </div>
                <div class="supervisor-password-div">
                    <label for="supervisor-password">Supervisor Password</label>
                    <input type="password" name="supervisor-password" id="supervisor-password" placeholder="Enter your Spervisor Password">
                    <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                    <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                </div>
                <div class="supervisor-selection-div">
                    <input type="checkbox" id="supervisor-selection">
                    <label for="supervisor-selection" class="custom-radio"></label>
                    <label for="supervisor-selection">Supervisor Login</label>
                </div>
                <a href="#" class="forgot-password-link">Forgot Password?</a>
                <img src="src/static/loading.gif" class="loading-gif" alt="loading_gif">
                <div class="btn-div">
                    <button name="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>

    $('#general-password').keyup(function (e) {
        // console.log(e.keyCode);
        if (e.keyCode == 17) {
            
            $('#supervisor-selection').prop('checked', true)
            setTimeout(() => {
            

                if ($('#supervisor-selection').prop('checked')) {
                    $('.supervisor-password-div').slideDown(100)
                    $('#supervisor-password').focus()
                } else {
                    $('.supervisor-password-div').slideUp(100)
                    $('#supervisor-password').focus()
                }
            }, 200);
        }
    })

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

    $('#supervisor-selection').change(function () {
        setTimeout(() => {
            
            if ($(this).prop('checked')) {
                $('.supervisor-password-div').slideDown(100)
                $('#supervisor-password').focus()
            } else {
                $('.supervisor-password-div').slideUp(100)
                $('#supervisor-password').focus()
            }
        }, 200);
    })

    $(".forgot-password-link").click(function () {
        $(".loading-gif").show()

        $.ajax({
            url: 'processors/account/send_mail.php',
            type: 'POST',
            data: {
                action: "send-mail"
            },
            success: function (data) {
                if (data == 1) {
                    $(".loading-gif").hide()
                    var msg = `<div class="msg success-msg">
                                    <div class="left">
                                        <ion-icon class="icon" name="checkmark-circle-outline"></ion-icon>
                                    </div>
                                    <div class="right">
                                        <p>A mail has been sent. Please check your mail.</p>
                                    </div>
                                </div>`;
                    $(msg).insertBefore('.head-main-container')
                } else {
                    console.log(data);
                }
            }
        })
    })
</script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>