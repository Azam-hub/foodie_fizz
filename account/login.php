<?php

require "../_config.php";
date_default_timezone_set("Asia/Karachi");
$msg = "";

session_start();

// Verifying account by code in url method
if (isset($_GET['code']) && $_GET['code'] !== "" && isset($_GET['action'])) {
    // Getting code from URL
    $url_code = $_GET['code'];

    // Getting Code from database and matching
    $get_code_sql = "SELECT * FROM `customers` WHERE `code` = '$url_code'";
    $get_code_res = mysqli_query($conn, $get_code_sql);
    $get_code_rows = mysqli_num_rows($get_code_res);

    // Checking
    if ($get_code_rows == 1) {
        
        if ($_GET['action'] == "first_verification") {
            // Updating Database
            $update_sql = "UPDATE `customers` SET `status` = 'active', `code` = '' WHERE `code` = '$url_code'";
            $update_res = mysqli_query($conn, $update_sql);

            if ($update_res) {
                $msg = success_msg("Your account has been verified successfully.");
                
            } else {
                $msg = danger_msg("Something went wrong!");
            }
            
            
        } elseif ($_GET['action'] == "email_verification" && isset($_GET['email'])) {
            $url_email = $_GET['email'];
            $update_sql = "UPDATE `customers` SET `email` = '$url_email', `code` = '' WHERE `code` = '$url_code'";
            $update_res = mysqli_query($conn, $update_sql);

            if ($update_res) {
                $msg = success_msg("Your email has been changed successfully.");
                // Logouting user after email update
                session_unset();
                session_destroy();
                
            } else {
                $msg = danger_msg("Something went wrong!");
            }

        } else {
            $msg = danger_msg("Incorrect Link!");    
        }
        
    } else {
        $msg = danger_msg("Incorrect Link!");        
    }
}

if (isset($_GET['password_changed'])) {
    $msg = success_msg("Your Password has been changed.");   
} elseif (isset($_GET['first_login'])) {
    $msg = danger_msg("First login to your account. Don't have an account? <a href='sign_up.php'>Sign Up here</a>");
}

// Checking if user logged in or not
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    header("location: ../index.php");
}

if (isset($_POST['login'])) {
    // Getting Fields Input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Checking fields are filled or not
    if ($email == "" || $password == "") {
        $msg = danger_msg("All fields are required.");
    } else {

        // Getting email and hashed password from database
        $get_email_password_sql = "SELECT * FROM `customers` WHERE `email` = '$email'";
        $get_email_password_res = mysqli_query($conn, $get_email_password_sql);
        $get_email_password_rows = mysqli_num_rows($get_email_password_res);

        // Checking email exist or not in database
        if ($get_email_password_rows != 1) {
            $msg = danger_msg("Incorrect Email or Password!");
        } else {
            // Fetching Data
            $data = mysqli_fetch_assoc($get_email_password_res);
            $db_password = $data['password'];
            $status = $data['status'];
            
            // Matching user and database password
            $match_password = password_verify($password, $db_password);

            if (!$match_password) {
                $msg = danger_msg("Incorrect Email or Password!");
            } else {
                
                if ($status == "active") {
                    
                    // Fetching Name
                    $db_customer_id = $data['customer_id'];
                    $db_name = $data['name'];
                    $db_phone = $data['mobile_no'];
    
                    // Defining SESSION
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['customer_id'] = $db_customer_id;
                    $_SESSION['name'] = $db_name;
                    $_SESSION['email'] = $email;
                    $_SESSION['phone'] = $db_phone;
    
                    header("location: ../index.php");
                } elseif ($status == "banned") {
                    $msg = danger_msg('You are banned by support team. You can contact <a href="../contact_us.php">here</a>.');
                                        
                } elseif ($status == "pending") {
                    $msg = danger_msg("First verify your account!");
                    
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

    <title>Login - Foodie Fizz</title>

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
    
    <link rel="stylesheet" href="../css/account/login.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_header.php"; ?>
    <?php echo $msg; ?>

    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Login</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="left">
                <form class="proper-form" method="POST">
                    <div class="email">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email">
                    </div>
                    <div class="password">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter your password">
                        <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                        <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
                    </div>
                    <a class="forgot-password" href="forgot_password.php">Forgot Password?</a>
                    <div class="form-sections btn">
                        <button type="submit" name="login">Login</button>
                    </div>
                </form>
                <p class="jump">Don't have an account? <a href="sign_up.php">Sign Up</a></p>
            </div>
            <div class="right">
                <img src="../img/account/login_pic.avif" alt="">
            </div>
        </div>
    </section>
    
    <?php include "_footer.php"; ?>

</div>
    
</body>

<!-- jQuery -->
<script src="../jquery/jquery-3.6.1.min.js"></script>

<script>
    // Eyes Method
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
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
    }
</script>

<!-- Header Footer Js -->
<script src="../js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>