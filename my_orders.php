<?php

require "_config.php";

// Checking if user logged in or not 
session_start();
if (!(isset($_SESSION['user_logged_in'])) || $_SESSION['user_logged_in'] == false) {
    header("location: index.php");
} else {
    $customer_id = $_SESSION['customer_id'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Orders - Foodie Fizz</title>

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
    
    <link rel="stylesheet" href="css/my_orders.css">
</head>
<body>

<div class="head-main-container">
    <?php include "_header.php"; ?>

    <div class="black-bg"></div>
    <div class="modal">
        <!-- <i class="fa-solid fa-xmark cross-icon"></i>
        <h1>Order Details</h1>
        <div class="order-details">
            <h4>Order Details</h4>
            <div class="details">
                <div class="left">
                    <p>Order ID: <span>1</span></p>
                    <p>Order Date: <span>04:53 pm || 30 May, 2023</span></p>
                    <p>Order Status: <span class="status pending-status">Pending</span></p>
                    <p>Actions: </p>
                    <div class="action-buttons">
                        <button data-order-id="1" class="action remove-action">Remove</button>
                    </div>
                </div>
                <div class="right">
                    <p>Payment Method: <span>Cash on Delivery</span></p>
                    <p>Delivery Charges: <span>Rs. 150</span></p>
                    <p>Promo Code: <span>No Promo Code</span></p>
                    <p>Address: <span>House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.</span></p>
                </div>
            </div>
        </div>
        <div class="order-items">
            <h4>Ordered Items</h4>
            <table>
                <tr>
                    <th>S.No.</th>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>1.</td>
                    <td><img src="../_test_img/Beef Biyani.jpg" alt="Item Pic"></td>
                    <td>Zinger Burger</td>
                    <td>Rs. 200</td>
                    <td>2</td>
                    <td>Rs. 400</td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td><img src="_test_img/Beef Biyani.jpg" alt="Item Pic"></td>
                    <td>Zinger Burger</td>
                    <td>Rs. 200</td>
                    <td>2</td>
                    <td>Rs. 400</td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td><img src="../_test_img/Beef Biyani.jpg" alt="Item Pic"></td>
                    <td>Zinger Burger</td>
                    <td>Rs. 200</td>
                    <td>2</td>
                    <td>Rs. 400</td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td><img src="../_test_img/Beef Biyani.jpg" alt="Item Pic"></td>
                    <td>Zinger Burger</td>
                    <td>Rs. 200</td>
                    <td>2</td>
                    <td>Rs. 400</td>
                </tr>
                <tr>
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
                    <td></td>
                    <td><b>Rs. 400</b></td>
                </tr>
            </table>
        </div> -->
    </div>

    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>My Orders</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="orders">

                <?php
                
                $get_order_sql = "SELECT * FROM `order_heads` WHERE `customer_id`='$customer_id' ORDER BY `id` DESC";
                $get_order_res = mysqli_query($conn, $get_order_sql);
                $get_order_rows = mysqli_num_rows($get_order_res);

                if ($get_order_rows > 0) {
                    
                    while ($order_data = mysqli_fetch_assoc($get_order_res)) {

                        $order_id = $order_data['id'];
                        $added_on = $order_data['added_on'];
                        $status = $order_data['status'];
                        $payment_method = $order_data['payment_method'];

                        $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

                        echo '<div data-order-id="'.$order_id.'" id="'.$order_id.'" class="order">
                                <div class="top">
                                    <div class="text order-id">
                                        <span class="head">Order ID:</span> 
                                        '.$order_id.'
                                    </div>
                                    <div class="text date-time">'.$modDate.'</div>
                                </div>
                                <div class="text order-status">
                                    <span class="head">Order Status:</span> ';

                                    if ($status == 'pending') {
                                        echo '<span class="status pending-status">Pending</span>';
                                    } elseif ($status == 'in-progress') {
                                        echo '<span class="status in-progress-status">In Progress</span>';
                                    } elseif ($status == 'delivered') {
                                        echo '<span class="status delivered-status">Delivered</span>';
                                    } elseif ($status == 'removed') {
                                        echo '<span class="status removed-status">Removed</span>';
                                    }

                                echo '</div>
                                <div class="text payment-type">
                                    <span class="head">Payment Type:</span> 
                                    '.$payment_method.'
                                </div>
                                <div class="btn">
                                    <button>See Details</button>
                                </div>
                            </div>';
                    }
                } else {
                    echo "You have no orders yet.";
                }
                
                
                ?>
                
                <!-- With "See details" button -->
                <!-- <div class="order">
                    <div class="top">
                        <div class="text order-id">
                            <span class="head">Order ID:</span> 
                            234
                        </div>
                        <div class="text date-time">03:35 pm || 07 Mar, 2023</div>
                    </div>
                    <div class="text order-status">
                        <span class="head">Order Status:</span> 
                        <span class="status pending-status">Pending</span>
                    </div>
                    <div class="text payment-type">
                        <span class="head">Payment Type:</span> 
                        Cash on Delivery
                    </div>
                    <div class="text total-amount">
                        <span class="head">Total Amount:</span> 
                        Rs: 1200
                    </div>
                    <div class="btn">
                        <button>See Details</button>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    
    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>
    $(document).on('click', '.order', function () {
        let order_id = $(this).data('order-id')
        
        $.ajax({
            url: 'processors/my_orders/order_details_fetcher.php',
            type: 'POST',
            data: {
                order_id: order_id
            },
            success: function (data) {
                if (data != 0) {
                    console.log(data);
                    $('.black-bg').show()
                    $('.modal').html(data)
                    $('.modal').show()

                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.remove-action', function () {
        let order_id = $(this).data('order-id')

        if (confirm("Are you sure?\nYou want to delete this order.")) {
                
            $.ajax({
                url: 'processors/my_orders/order_deleter.php',
                type: 'POST',
                data: {
                    order_id: order_id
                },
                success: function (data) {
                    if (data == 1) {
                        
                        $(`#${order_id} .order-status .status`).text('Removed')
                        $(`#${order_id} .order-status .status`).addClass('removed-status')

                        $('.black-bg').hide()
                        $('.modal').hide()
                        $('.modal').html('')
                    } else {
                        console.log(data);
                    }
                }
            })
        }
    })

    $(document).on('click', '.cross-icon', function () {
        $('.black-bg').hide()
        $('.modal').hide()
        $('.modal').html('')
    })
    $('.black-bg').click(function () {
        $('.black-bg').hide()
        $('.modal').hide()
        $('.modal').html('')
    })
</script>

<!-- Header Footer Js -->
<script src="js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>