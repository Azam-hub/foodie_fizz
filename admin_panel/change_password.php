<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
session_start();
$msg = "";

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true && 
( isset($_SESSION['general_logged_in']) || isset($_SESSION['supervisor_logged_in']) )) {
    header("location: index.php");
}

if (!(isset($_GET['code']))) {
    header("location: login.php");
}

if (isset($_POST['submit-general-password'])) {
    // Fetching fields input
    $password = $_POST['general-password'];
    $confirm_password = $_POST['general-confirm-password'];

    if ($password == "" || $confirm_password == "") {
        $msg = danger_msg("All fields are required.");
    } else {
        
        // Check Supervior want to login or not
        if ($password !== $confirm_password) {
            $msg = danger_msg("Password and Confirm Password does not match.");
        } else {
            // Getting code from database
            $get_sql = "SELECT * FROM `admin_panel_credential` WHERE `id` = '1'";
            $get_res = mysqli_query($conn, $get_sql);
            $data = mysqli_fetch_assoc($get_res);
            $code = $data['code'];

            if ($code !== $_GET['code']) {
                $msg = danger_msg("Incorrect Link!");
            } else {
                // Hashing Password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Updating database
                $update_sql = "UPDATE `admin_panel_credential` SET `code` = '', `general_password` = '$hashed_password' WHERE `id` = '1'";
                $update_res = mysqli_query($conn, $update_sql);
            
                if ($update_res) {
                    header("location: login.php?password_changed");
                } else {
                    $msg = danger_msg("Something went wrong! Please try again later.");
                }
            }
        }
    }
}


if (isset($_POST['submit-supervisor-password'])) {
    // Fetching fields input
    $supervisor_password = $_POST['supervisor-password'];
    $supervisor_confirm_password = $_POST['supervisor-confirm-password'];

    if ($supervisor_password == "" || $supervisor_confirm_password == "") {
        $msg = danger_msg("All fields are required.");
    } else {
        
        // Check Supervior want to login or not
        if ($supervisor_password !== $supervisor_confirm_password) {
            $msg = danger_msg("Password and Confirm Password does not match.");
        } else {
            // Getting code from database
            $get_sql = "SELECT * FROM `admin_panel_credential` WHERE `id` = '1'";
            $get_res = mysqli_query($conn, $get_sql);
            $data = mysqli_fetch_assoc($get_res);
            $code = $data['code'];

            if ($code !== $_GET['code']) {
                $msg = danger_msg("Incorrect Link!");
            } else {
                // Hashing Password
                $hashed_password = password_hash($supervisor_password, PASSWORD_BCRYPT);

                // Updating database
                $update_sql = "UPDATE `admin_panel_credential` SET `code` = '', `supervisor_password` = '$hashed_password' WHERE `id` = '1'";
                $update_res = mysqli_query($conn, $update_sql);
            
                if ($update_res) {
                    header("location: login.php?password_changed");
                } else {
                    $msg = danger_msg("Something went wrong! Please try again later.");
                }
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

    <title>Change Password - Foodie Fizz</title>

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
                <div class="general-password">
                    <h3>Change General Password</h3>
                    <div class="general-password-div">
                        <label for="password">Password</label>
                        <input type="password" name="general-password" id="password" placeholder="Enter your Password">
                        <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                        <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                    </div>
                    <div class="general-password-div">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="general-confirm-password" id="confirm-password" placeholder="Enter your Confirm Password">
                        <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                        <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                    </div>
                    <div class="btn-div">
                        <button name="submit-general-password">Change Password</button>
                    </div>
                </div>
            </form>

            <form method="POST">
                <div class="supervisor-password-head-div">
                    <h3>Change Supervisor Password</h3>
                    <div class="general-password-div">
                        <label for="password">Password</label>
                        <input type="password" name="supervisor-password" id="password" placeholder="Enter your Password">
                        <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                        <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                    </div>
                    <div class="general-password-div">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="supervisor-confirm-password" id="confirm-password" placeholder="Enter your Confirm Password">
                        <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                        <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                    </div>
                    <div class="btn-div">
                        <button name="submit-supervisor-password">Change Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>
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

</script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>