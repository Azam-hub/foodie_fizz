<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");

if (isset($_GET['order_id'])) {
    $url_order_id = $_GET['order_id'];
} else {
    header('location: orders.php');
}

$delivery_charges = 150;


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
    
    <link rel="stylesheet" href="css/order_details.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_sidebar.php"; ?>

    <div class="main-container">

        <?php include "_header.php"; ?>

        <div class="section">
            <div class="upper-section">
                <div class="left">
                    <h2>Order Details</h2>
                </div>
            </div>
            <div class="downer-section">
                <div class="order-user-details">
                    <?php
                    
                    // Getting order head detail
                    $get_order_head_details_sql = "SELECT * FROM `order_heads` WHERE `id`='$url_order_id'";
                    $get_order_head_details_res = mysqli_query($conn, $get_order_head_details_sql);
                    $get_order_head_details_rows = mysqli_num_rows($get_order_head_details_res);

                    if ($get_order_head_details_rows > 0) {
                        $order_head_data = mysqli_fetch_assoc($get_order_head_details_res);

                        $order_id = $order_head_data['id'];
                        $added_on = $order_head_data['added_on'];
                        $payment_method = $order_head_data['payment_method'];
                        $status = $order_head_data['status'];
                        $customer_name = $order_head_data['customer_name'];
                        $customer_email = $order_head_data['customer_email'];
                        $customer_phone_no = $order_head_data['customer_phone_no'];
                        $promo_code_id = $order_head_data['promo_code_id'];
                        $address = $order_head_data['address'];

                        $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

                        echo '<div class="order-details">
                                <h4 class="section-head">Order Details</h4>
                                <div class="details">
                                    <p>Order ID: <span>'.$order_id.'</span></p>
                                    <p>Order Date: <span>'.$modDate.'</span></p>
                                    <p>Payment Method: <span>'.$payment_method.'</span></p>
                                    <p>Delivery Charges: <span>Rs. '.$delivery_charges.'</span></p>
                                    <!-- <p>Total Amount: <span>Rs. 2200</span></p> -->';

                                    if ($promo_code_id != "") {
                                        $get_promo_code_sql = "SELECT * FROM `promo_code` WHERE `id`='$promo_code_id'";
                                        $get_promo_code_res = mysqli_query($conn, $get_promo_code_sql);
                                        $promo_code_data = mysqli_fetch_assoc($get_promo_code_res);

                                        $promo_code = $promo_code_data['promo_code'];
                                        $discount = $promo_code_data['discount'];
                                        $discount_mode = $promo_code_data['discount_mode'];

                                        echo '<p>Promo Code: <span>'.$promo_code.'</span></p>
                                        <p>Discount: <span>'.$discount.' ('.$discount_mode.')</span></p>';
                                    } else {
                                        echo '<p>Promo Code: <span>No Promo code</span></p>';
                                    }
                                    

                                    if ($status == 'pending') {
                                        echo '<p>Order Status: <span class="status pending-status">Pending</span></p>
                                        <p class="hide">Order Status: <span class="status in-progress-status">In Progress</span></p>
                                        <p class="hide">Order Status: <span class="status delivered-status">Delivered</span></p>';
                                    } elseif ($status == 'in-progress') {
                                        echo '<p class="hide">Order Status: <span class="status pending-status">Pending</span></p>
                                        <p>Order Status: <span class="status in-progress-status">In Progress</span></p>
                                        <p class="hide">Order Status: <span class="status delivered-status">Delivered</span></p>';
                                        
                                    } elseif ($status == 'delivered') {
                                        echo '<p class="hide">Order Status: <span class="status pending-status">Pending</span></p>
                                        <p class="hide">Order Status: <span class="status in-progress-status">In Progress</span></p>
                                        <p>Order Status: <span class="status delivered-status">Delivered</span></p>';
                                        
                                    } elseif ($status == 'removed') {
                                        echo '<p>Order Status: <span class="status removed-status">Removed</span></p>';
                                        
                                    }

                                    echo '<p>Actions: </p>
                                    <div class="action-buttons">';
                                        if ($status == 'pending') {
                                            echo '<button data-order-id="'.$order_id.'" class="action in-progress-action">Put in progress</button><button data-order-id="'.$order_id.'" class="action deliver-action hide">Delivered</button>';
                                        } elseif ($status == 'in-progress') {
                                            echo '<button data-order-id="'.$order_id.'" class="action in-progress-action hide">Put in progress</button>
                                            <button data-order-id="'.$order_id.'" class="action deliver-action">Delivered</button>';
                                            
                                        } elseif ($status == 'delivered') {
                                            echo '';
                                            
                                        }
                                        echo '<button data-order-id="'.$order_id.'" class="action remove-action">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <div class="user-details">
                                <h4 class="section-head">User Details</h4>
                                <div class="details">
                                    <p>Name: <span>'.$customer_name.'</span></p>
                                    <p>Email ID: <span>'.$customer_email.'</span></p>
                                    <p>Phone: <span>'.$customer_phone_no.'</span></p>
                                    <p>Address Code: <span>'.$address.'</span></p>
                                </div>
                            </div>';
                    } else {
                        echo '<script>location.href = "orders.php"</script>';
                    }
                    
                    
                    ?>
                    <!-- <div class="order-details">
                        <h4 class="section-head">Order Details</h4>
                        <div class="details">
                            <p>Order ID: <span>6</span></p>
                            <p>Ordered Date: <span>03:35 pm <b>||</b> 07 Mar, 2023</span></p>
                            <p>Payment Method: <span>Cash on Delivery</span></p>
                            <p>Total Amount: <span>Rs. 2200</span></p>
                            <p>Order Status: <span class="status pending-status">Pending</span></p>
                            <p>Actions: </p>
                            <div class="action-buttons">
                                <button class="action in-progress-action">Put in Progress</button>
                                <button class="action remove-action">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="user-details">
                        <h4 class="section-head">User Details</h4>
                        <div class="details">
                            <p>Name: <span>Muhammad Azam</span></p>
                            <p>Email ID: <span>azam78454@gmail.com</span></p>
                            <p>Phone: <span>0333-2332332</span></p>
                            <p>Address Code: <span>House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.</span></p>
                        </div>
                    </div> -->
                </div>
                <div class="order-items">
                    <h4 class="section-head">Ordered Items</h4>
                    <div class="table">
                        <table>
                            <tr>
                                <th>S.No.</th>
                                <th>Image</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                            <?php
                            
                            // Ordered items data
                            $get_ordered_items_sql = "SELECT * FROM `ordered_items` WHERE `order_id`='$url_order_id'";
                            $get_ordered_items_res = mysqli_query($conn, $get_ordered_items_sql);

                            $grand_total = 0;
                            while ($ordered_items_data = mysqli_fetch_assoc($get_ordered_items_res)) {
                                $item_id = $ordered_items_data['item_id'];
                                $quantity = $ordered_items_data['quantity'];

                                // Items detials
                                $get_item_details_sql = "SELECT * FROM `items` WHERE `item_id`='$item_id'";
                                $get_item_details_res = mysqli_query($conn, $get_item_details_sql);
                                $item_details_data = mysqli_fetch_assoc($get_item_details_res);

                                $item_name = $item_details_data['item_name'];
                                $item_price = $item_details_data['item_price'];
                                $image_path = $item_details_data['image_path'];

                                echo '<tr>
                                        <td>'.$item_id.'.</td>
                                        <td><img src="'.$image_path.'" alt="Item Pic"></td>
                                        <td>'.$item_name.'</td>
                                        <td>Rs. '.$item_price.'</td>
                                        <td>'.$quantity.'</td>
                                        <td>Rs. '.($row_total = $item_price * $quantity).'</td>
                                    </tr>
                                    ';
                                $grand_total = $grand_total + $row_total;
                            }
                            $grand_total = $grand_total + $delivery_charges;
                            echo '<tr>
                                    <td><b>Total Amount :</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    ';
                                    if ($promo_code_id != "") {
                                        $get_promo_code_sql = "SELECT * FROM `promo_code` WHERE `id`='$promo_code_id'";
                                        $get_promo_code_res = mysqli_query($conn, $get_promo_code_sql);
                                        $promo_code_data = mysqli_fetch_assoc($get_promo_code_res);

                                        $promo_code = $promo_code_data['promo_code'];
                                        $discount = $promo_code_data['discount'];
                                        $discount_mode = $promo_code_data['discount_mode'];

                                        echo '<td><b>'.$promo_code.'</b>: '.$discount.' ('.$discount_mode.')</td>';
                                        
                                        // Applying promo code
                                        if ($discount_mode == 'In Rupees (PKR)') {
                                            $to_pay_amount = $grand_total - $discount;
                                        } elseif ($discount_mode == 'In Percentage (%)') {
                                            $discount_in_rupees = ($discount / 100) * $grand_total;
                                            $to_pay_amount = $grand_total - round($discount_in_rupees);
                                        }

                                        echo '<td>
                                            <span style="font-size: 14px; text-decoration: line-through;">Rs. '.$grand_total.'</span>
                                            <b>Rs. '.$to_pay_amount.'</b>
                                        </td>';
                                    } else {
                                        echo '<td></td>
                                        <td><b>Rs. '.$grand_total.'</b></td>';
                                    }
                                    
                                echo '</tr>';
                            
                            ?>
                            <!-- <tr>
                                <td>1.</td>
                                <td><img src="../_test_img/Beef Biyani.jpg" alt="Item Pic"></td>
                                <td>Zinger Burger</td>
                                <td>Rs. 200</td>
                                <td>2</td>
                                <td>Rs. 400</td>
                            </tr>
                            <tr>
                                <td><b>Total Amount :</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Rs. 400</b></td>
                            </tr> -->
                        </table>
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

    $(document).on('click', '.in-progress-action', function () {
        let this_btn = $(this)
        let order_id = $(this).data('order-id')

        $.ajax({
            url: 'processors/orders/status_changer.php',
            type: 'POST',
            data: {
                action: "in-progress",
                order_id: order_id
            },
            success: function (data) {
                if (data == 1) {
                    $(this_btn).hide()
                    $(this_btn).next().show()

                    $(this_btn).parent().prev().prev().prev().prev().hide()
                    $(this_btn).parent().prev().prev().prev().show()
                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.deliver-action', function () {
        let this_btn = $(this)
        let order_id = $(this).data('order-id')

        $.ajax({
            url: 'processors/orders/status_changer.php',
            type: 'POST',
            data: {
                action: "deliver",
                order_id: order_id
            },
            success: function (data) {
                if (data == 1) {
                    $(this_btn).hide();

                    $(this_btn).parent().prev().prev().prev().hide()
                    $(this_btn).parent().prev().prev().show()
                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.remove-action', function () {
        let this_btn = $(this)
        let order_id = $(this).data('order-id')

        $.ajax({
            url: 'processors/orders/status_changer.php',
            type: 'POST',
            data: {
                action: "remove",
                order_id: order_id
            },
            success: function (data) {
                if (data == 1) {
                    location.href = "orders.php"
                } else {
                    console.log(data);
                }
            }
        })
    })
</script>

<!-- Sidebar Hide/Show -->
<script src="js/sidebar_show_hide.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>