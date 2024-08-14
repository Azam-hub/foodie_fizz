<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
session_start();
$msg = "";


// Get data sql
$get_sql = "SELECT * FROM `admin_panel_credential` WHERE `id` = '1'";
$get_res = mysqli_query($conn, $get_sql);
$data = mysqli_fetch_assoc($get_res);
$email = $data['email'];

// Logic for general password
if (isset($_POST['update-general-password'])) {
    // Fetching fields input
    $general_old_password = $_POST['general-old-password'];
    $general_new_password = $_POST['general-new-password'];
    $general_confirm_password = $_POST['general-confirm-password'];

    if ($general_old_password == "" || $general_new_password == "" || $general_confirm_password == "") {
        $msg = danger_msg("All fields are required.");
    } else {
        if ($general_new_password !== $general_confirm_password) {
            $msg = danger_msg("Password and Confirm Password does not match.");
        } else {
            // Check only general password
            $db_general_password = $data['general_password'];
            $match_general_password = password_verify($general_old_password, $db_general_password);
    
            // Matching
            if (!$match_general_password) {
                $msg = danger_msg("Old password is not correct.");
            } else {
                // Hashing new password
                $hashed_general_password = password_hash($general_new_password, PASSWORD_BCRYPT);
                
                // Updating Database
                $update_sql = "UPDATE `admin_panel_credential` SET `general_password` = '$hashed_general_password' WHERE `id` = '1'";
                $update_res = mysqli_query($conn, $update_sql);

                if ($update_res) {
                    $msg = success_msg("General Password has been changed successfully.");
                } else {
                    $msg = danger_msg("Something went wrong! Please try again later.");
                }
            }
        }
    }
}

// Logic for supervisor password
if (isset($_POST['update-supervisor-password'])) {
    // Fetching fields input
    $supervisor_old_password = $_POST['supervisor-old-password'];
    $supervisor_new_password = $_POST['supervisor-new-password'];
    $supervisor_confirm_password = $_POST['supervisor-confirm-password'];

    if ($supervisor_old_password == "" || $supervisor_new_password == "" || $supervisor_confirm_password == "") {
        $msg = danger_msg("All fields are required.");
    } else {
        if ($supervisor_new_password !== $supervisor_confirm_password) {
            $msg = danger_msg("Password and Confirm Password does not match.");
        } else {
            // Check only supervisor password
            $db_supervisor_password = $data['supervisor_password'];
            $match_supervisor_password = password_verify($supervisor_old_password, $db_supervisor_password);
    
            // Matching
            if (!$match_supervisor_password) {
                $msg = danger_msg("Old password is not correct.");
            } else {
                // Hashing new password
                $hashed_supervisor_password = password_hash($supervisor_new_password, PASSWORD_BCRYPT);
                
                // Updating Database
                $update_sql = "UPDATE `admin_panel_credential` SET `supervisor_password` = '$hashed_supervisor_password' WHERE `id` = '1'";
                $update_res = mysqli_query($conn, $update_sql);

                if ($update_res) {
                    $msg = success_msg("Supervisor Password has been changed successfully.");
                } else {
                    $msg = danger_msg("Something went wrong! Please try again later.");
                }
            }
        }
    }
}

// Logic for email
if (isset($_POST['update-email'])) {
    // Fetching fields input
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if ($email == "") {
        $msg = danger_msg("Email field is required.");
    } else {
        // Updating Database
        $update_sql = "UPDATE `admin_panel_credential` SET `email` = '$email' WHERE `id` = '1'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            $msg = success_msg("Email has been changed successfully.");
        } else {
            $msg = danger_msg("Something went wrong! Please try again later.");
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

    <title>Admin Panel - Foodie Fizz</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Pattaya&family=Racing+Sans+One&display=swap" rel="stylesheet">

    <!-- Fontawesome Link -->
    <link rel="stylesheet" href="fontawesome_icon/css/all.min.css">

    <!-- Local Links -->
    <link rel="shortcut icon" href="src/static/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/_utils.css">
    <link rel="stylesheet" href="css/_sidebar_header.css">
    
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

<div class="head-main-container">

    <div class="black-bg"></div>

    <div class="modal email-modal">
        <i class="fa-solid fa-xmark cross-icon"></i>
        <div class="head"><h1>Update Email</h1></div>
        <form method="POST">
            <div>
                <label for="input-field">Enter your New Email</label>
                <input type="email" placeholder="Enter your New Email" name="email" autofocus>
            </div>
            <button name="update-email">Update</button>
        </form>
    </div>

    <div class="modal password-modal">
        <i class="fa-solid fa-xmark cross-icon"></i>
        <div class="head"><h1>Update Password</h1></div>
        <form method="POST">
            <div>
                <label for="input-field">Enter your Old Password</label>
                <input type="password" placeholder="Old Password" autofocus>
                <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
            </div>
            <div>
                <label for="input-field">Enter your New Password</label>
                <input type="password" placeholder="New Password">
                <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
            </div>
            <div>
                <label for="input-field">Re-enter your New Password</label>
                <input type="password" placeholder="Re-enter New Password">
                <ion-icon class="eye open-eye" name="eye-outline"></ion-icon>
                <ion-icon class="eye close-eye" name="eye-off-outline"></ion-icon>
            </div>
            <button>Update</button>
        </form>
    </div>


    <?php include "_sidebar.php"; ?>

    <div class="main-container">

        <?php include "_header.php"; ?>
        <?php echo $msg; ?>

        <div class="section">
            <div class="upper-section">
                <h2>Security</h2>
            </div>
            <div class="downer-section">
                <div class="infos">
                    <div class="info email">
                        <h3>Email</h3>
                        <p><?php echo $email; ?></p>
                        <button id="email-btn">Update</button>
                    </div>
                    <div class="hidden"></div>
                    <div class="info general-password">
                        <h3>General Password</h3>
                        <button id="password-btn">Update</button>
                    </div>
                    <div class="info supervisor-password">
                        <h3>Supervisor Password</h3>
                        <button id="supervisor-password-btn">Update</button>
                    </div>
                </div>
                <div class="updates">
                    <h2>Updates</h2>
                    <div class="grid">
                        <div class="left">
                            <div class="orders-table">
                                <!-- <h3>New Orders</h3>
                                <table>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>11.</td>
                                        <td>You have new order from <b><q>Azam</q></b></td>
                                        <td><a href="#" class="action view-btn">View</a></td>
                                    </tr>
                                </table> -->
                            </div>
                        </div>
                        
                        <div class="right">
                            <div class="reservation-table">
                                <!-- <h3>New Queries</h3>
                                <table>
                                    <tr>
                                        <th>Query ID</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>11.</td>
                                        <td>You have new query from <b><q>Azam</q></b></td>
                                        <td><a href="#" class="action view-btn">View</a></td>
                                    </tr>
                                </table> -->
                            </div>
                            <div class="query-table">
                                <!-- <h3>New Reservations</h3>
                                <table>
                                    <tr>
                                        <th>Reservation ID</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>11.</td>
                                        <td>You have new Reservation from <b><q>Azam</q></b></td>
                                        <td><a href="#" class="action view-btn">View</a></td>
                                    </tr>
                                </table> -->
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>

    // --------------- Check new reocrds added --------------------
    // function check_new_records(orders_last_seen, queries_last_seen, reservation_last_seen) {
    //     $.ajax({
    //         url: 'processors/home/check_new_records.php',
    //         type: 'POST',
    //         data: {
    //             orders_last_seen: orders_last_seen,
    //             queries_last_seen: queries_last_seen,
    //             reservation_last_seen: reservation_last_seen
    //         },
    //         success: function (data) {
    //             data = JSON.parse(data)
    //             let orders_data = data[0];
    //             let queries_data = data[1];
    //             let reservations_data = data[2];

    //             if (orders_data != "") {
    //                 let order_html = `<div class="table">
    //                 <h3>New Orders</h3>
    //                     <table>
    //                         <tr>
    //                             <th>Order ID</th>
    //                             <th>Description</th>
    //                             <th>Action</th>
    //                         </tr>
    //                         ${orders_data}
    //                     </table>
    //                 </div>`
    //                 $('.orders-table').html(order_html)
    //             }
    //             if (queries_data != "") {
    //                 let query_html = `<div class="table">
    //                 <h3>New Queries</h3>
    //                     <table>
    //                         <tr>
    //                             <th>Query ID</th>
    //                             <th>Description</th>
    //                             <th>Action</th>
    //                         </tr>
    //                         ${queries_data}
    //                     </table>
    //                 </div>`
    //                 $('.query-table').html(query_html)
    //             }
    //             if (reservations_data != "") {
    //                 let reservation_html = `<div class="table">
    //                 <h3>New Reservations</h3>
    //                     <table>
    //                         <tr>
    //                             <th>Reservation ID</th>
    //                             <th>Description</th>
    //                             <th>Action</th>
    //                         </tr>
    //                         ${reservations_data}
    //                     </table>
    //                 </div>`
    //                 $('.reservation-table').html(reservation_html)
    //             }
    //         }
    //     })
    // }

    // let orders_last_seen = localStorage.getItem('orders_last_seen')
    // let queries_last_seen = localStorage.getItem('queries_last_seen')
    // let reservation_last_seen = localStorage.getItem('reservation_last_seen')
    // check_new_records(orders_last_seen, queries_last_seen, reservation_last_seen)

    // setInterval(() => {

    //     let orders_last_seen = localStorage.getItem('orders_last_seen')
    //     let queries_last_seen = localStorage.getItem('queries_last_seen')
    //     let reservation_last_seen = localStorage.getItem('reservation_last_seen')
        
    //     check_new_records(orders_last_seen, queries_last_seen, reservation_last_seen)
    // }, 2000);
    


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

    $(".main-container .section .downer-section button").click(function () {
        var btn = $(this)
        var action = $(this).attr('id')
        var text = $(this).prev().text()

        $('.black-bg').show()
        
        if (action == "email-btn") {
            $(".email-modal").show()
            $(".email-modal form input").focus()

            $(".email-modal form input").val(text)
            $(".email-modal form input").focus()
        }
        else if (action == "password-btn") {
            $(".password-modal").show()
            $(".password-modal form div:nth-child(1) input").focus()

            $(".password-modal h1").text('Update General Password')
            $(".password-modal form input").attr('type', 'password')

            $(".password-modal form div:nth-child(1) label").text('Enter your Old Password')
            $(".password-modal form div:nth-child(1) input").attr('name', 'general-old-password')
            $(".password-modal form div:nth-child(1) input").attr('placeholder', 'Enter your Old Password')

            $(".password-modal form div:nth-child(2) label").text('Enter your New Password')
            $(".password-modal form div:nth-child(2) input").attr('name', 'general-new-password')
            $(".password-modal form div:nth-child(2) input").attr('placeholder', 'Enter your New Password')

            $(".password-modal form div:nth-child(3) label").text('Re-enter your New Password')
            $(".password-modal form div:nth-child(3) input").attr('name', 'general-confirm-password')
            $(".password-modal form div:nth-child(3) input").attr('placeholder', 'Re-enter your New Password')
            
            $(".password-modal form button").attr('name', 'update-general-password')
        }
        else if (action == "supervisor-password-btn") {
            $(".password-modal").show()
            $(".password-modal form div:nth-child(1) input").focus()

            $(".password-modal h1").text('Update Supervisor Password')
            $(".password-modal form input").attr('type', 'password')

            $(".password-modal form div:nth-child(1) label").text('Enter your Old Password')
            $(".password-modal form div:nth-child(1) input").attr('name', 'supervisor-old-password')
            $(".password-modal form div:nth-child(1) input").attr('placeholder', 'Enter your Old Password')

            $(".password-modal form div:nth-child(2) label").text('Enter your New Password')
            $(".password-modal form div:nth-child(2) input").attr('name', 'supervisor-new-password')
            $(".password-modal form div:nth-child(2) input").attr('placeholder', 'Enter your New Password')

            $(".password-modal form div:nth-child(3) label").text('Re-enter your New Password')
            $(".password-modal form div:nth-child(3) input").attr('name', 'supervisor-confirm-password')
            $(".password-modal form div:nth-child(3) input").attr('placeholder', 'Re-enter your New Password')

            $(".password-modal form button").attr('name', 'update-supervisor-password')
        }
    })
</script>

<!-- Sidebar Hide/Show -->
<script src="js/sidebar_show_hide.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>