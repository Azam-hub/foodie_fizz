<?php

require "_config.php";

// Checking if user logged in or not 
session_start();
if (!(isset($_SESSION['user_logged_in'])) || $_SESSION['user_logged_in'] == false) {
    header("location: index.php");
} else {
    $customer_id = $_SESSION['customer_id'];
}

date_default_timezone_set("Asia/Karachi");
$datetime = date("Y-m-d H:i:s");

$msg = "";

if (isset($_POST['add-address-btn'])) {
    // Getting inputed values
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if ($address == "") {
        $msg = danger_msg("Please enter address.");
    } else {
        $insert_sql = "INSERT INTO `address` (`address`, `customer_id`, `added_on`) VALUES ('$address', '$customer_id', '$datetime')";
        $insert_res = mysqli_query($conn, $insert_sql);
    
        if ($insert_res) {
            $msg = success_msg("Your address has been added successfully.");
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

    <title>My Addresses - Foodie Fizz</title>

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
    <link rel="shortcut icon" href="img/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/_utils.css">
    <link rel="stylesheet" href="css/_header_footer.css">
    
    <link rel="stylesheet" href="css/my_addresses.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_header.php"; ?>

    <?php echo $msg; ?>

    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>My Addresses</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="info address-container">
                <form method="POST">
                    <h2 class="head add-addresses">Add Address</h2>
                    <textarea name="address" cols="30" rows="10" placeholder="Enter your Address"></textarea>
                    <button id="address-btn" name="add-address-btn">+ Add Address</button>
                </form>
                <h2 class="head your-addresses">Addresses</h2>
                <div class="addresses">
                    <?php
                    $get_address_sql = "SELECT * FROM `address` WHERE `customer_id`='$customer_id' ORDER BY `id` DESC";
                    $get_address_res = mysqli_query($conn, $get_address_sql);
                    $get_address_rows = mysqli_num_rows($get_address_res);
                    
                    if ($get_address_rows > 0) {
                        
                        while ($address_data = mysqli_fetch_assoc($get_address_res)) {
                            $address_id = $address_data['id'];
                            $address = $address_data['address'];

                            echo '<div class="address">
                                    <i data-address-id="'.$address_id.'" class="fa-regular fa-trash-can delete-address"></i>
                                    '.$address.'
                                </div>';
                        }
                    } else {
                        echo 'No addresses.';
                    }
                    
                    ?>
                    <!-- <div class="address"><i class="fa-regular fa-trash-can"></i>House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.</div>
                    <div class="address"><i class="fa-regular fa-trash-can"></i>House#11 .</div>
                    <div class="address"><i class="fa-regular fa-trash-can"></i>House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.</div>
                    <div class="address"><i class="fa-regular fa-trash-can"></i>House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.</div> -->
                </div>
            </div>
        </div>
    </section>
    
    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>
    $(document).on('click', '.delete-address', function () {
        var address_id = $(this).data('address-id')
        var this_btn = $(this)

        $.ajax({
            url: "processors/addresses/delete_address.php",
            type: "POST",
            data: {
                address_id: address_id
            },
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $(this_btn).parent().fadeOut(200)
                } else {
                    console.log(data);
                }
            }
        })
    })
</script>

<!-- Header Footer Js -->
<script src="js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>