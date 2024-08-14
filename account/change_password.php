<?php

require "../_config.php";
date_default_timezone_set("Asia/Karachi");

session_start();
// Checking if user logged in or not
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    header("location: ../index.php");
}

$msg = "";

$allow = false;

// Checking code is correct or not
if (isset($_GET['code']) && $_GET['code'] != "") {

    // Getting code from URL
    $url_code = $_GET['code'];
    
    // Getting code from Database
    $get_code_sql = "SELECT * FROM `customers` WHERE `code` = '$url_code'";
    $get_code_res = mysqli_query($conn, $get_code_sql);
    $get_code_rows = mysqli_num_rows($get_code_res);

    // Checking exist or not
    if ($get_code_rows == 1) {
        $allow = true;
    }
    
} else {
    header("location: ../index.php");
}

if (isset($_POST['submit'])) {

    // Getting Fields Input
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Checking fields are filled or not
    if ($password == "" || $confirm_password == "") {
        $msg = danger_msg("All fields are required.");
    } else {
        
        // Checking Password and Confirm Password are matching or not
        if ($password !== $confirm_password) {
            $msg = danger_msg("Password and Confirm Password does not match.");
        } else {

            // Hashing password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Checking if code is correct or not
            if ($allow) {

                // Updating database
                $update_sql = "UPDATE `customers` SET `password` = '$hashed_password', `code` = '' WHERE `code` = '$url_code'";
                $update_res = mysqli_query($conn, $update_sql);

                if ($update_res) {
                    $msg = success_msg("Your Password has been changed successfully.");
                    sleep(3);
                    header("location: login.php?password_changed");
                } else {
                    $msg = danger_msg("Something went wrong!");
                }
                
            } else {
                $msg = danger_msg("Incorrect Link!");
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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Pattaya&family=Racing+Sans+One&display=swap" rel="stylesheet">

    <!-- Fontawesome Link -->
    <link rel="stylesheet" href="../fontawesome_icon/css/all.min.css">

    <!-- Local Links -->
    <link rel="shortcut icon" href="../img/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/_utils.css">
    <link rel="stylesheet" href="../css/_header_footer.css">
    <link rel="stylesheet" href="../css/_form.css">
    
    <link rel="stylesheet" href="../css/account/change_password.css">
</head>
<body>

<div class="head-main-container">
    
    <?php include "_header.php"; ?>
    <?php echo $msg; ?>

    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Change Password</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="left">
                <form class="proper-form" method="POST">
                    <div class="password">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter your password">
                        <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                        <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                    </div>
                    <div class="confirm-password">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="Enter your confirm password">
                        <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                        <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                    </div>
                    <div class="form-sections btn">
                        <button type="submit" name="submit">Change Password</button>
                    </div>
                </form>
                <p class="jump">Go back to <a href="login.php">Login</a></p>
            </div>
            <div class="right">
                <img src="../img/account/change_password.png" alt="">
            </div>
        </div>
    </section>
    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="../jquery/jquery-3.6.1.min.js"></script>

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

    // Function to remove get parameters from url
    // if(typeof window.history.pushState == 'function') {
    //     window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
    // }
</script>

<!-- Header Footer Js -->
<script src="../js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>