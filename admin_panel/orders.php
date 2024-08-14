<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
$current_datetime = date("YnjHis");
// echo $current_datetime;

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
    
    <link rel="stylesheet" href="css/orders.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_sidebar.php"; ?>

    <div class="main-container">

        <?php include "_header.php"; ?>

        <div class="section">
            <div class="section-1">
                <div class="upper-section">
                    <div class="left">
                        <h2>Customer Orders</h2>
                    </div>
                    <div class="right">
                        <label for="search-order">Search Order</label>
                        <input type="text" id="search-order" placeholder="Search...">
                    </div>
                </div>
                <div class="downer-section">
                    <?php
                        
                    // Getting order head data
                    $get_order_head_sql = "SELECT * FROM `order_heads` WHERE (`status`='pending') OR (`status`='in-progress') OR (`status`='removed') ORDER BY `id` DESC";
                    $get_order_head_res = mysqli_query($conn, $get_order_head_sql);
                    $get_order_head_rows = mysqli_num_rows($get_order_head_res);

                    if ($get_order_head_rows > 0) {

                        echo '<table>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <!-- <th>Email</th>
                            <th>Mobile Number</th> -->
                            <th>Payment Method</th>
                            <th>Ordered At</th>
                            <th>Status</th>
                            <th>View</th>
                            <th>Other Actions</th>
                        </tr>';

                        while ($order_head_data = mysqli_fetch_assoc($get_order_head_res)) {

                            $order_id = $order_head_data['id'];
                            $customer_name = $order_head_data['customer_name'];
                            $payment_method = $order_head_data['payment_method'];
                            $status = $order_head_data['status'];
                            $added_on = $order_head_data['added_on'];

                            $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));                              
                            
                            echo '<tr id="'.$order_id.'">
                                    <td>'.$order_id.'</td>
                                    <td>'.$customer_name.'</td>
                                    <!-- <td>azam78454@gmail.com</td>
                                    <td>03333333333</td> -->
                                    <td>'.$payment_method.'</td>
                                    <td>'.$modDate.'</td>
                                    <td>';
                                        if ($status == "pending") {
                                            echo '<span class="status pending-status">Pending</span>
                                            <span class="status in-progress-status hide">In Progress</span>';
                                        } elseif ($status == "in-progress") {
                                            echo '<span class="status pending-status hide">Pending</span>
                                            <span class="status in-progress-status">In Progress</span>';
                                        } elseif ($status == "removed") {
                                            echo '<span class="status removed-status">Removed</span>';
                                        }
                                    echo '</td>
                                    <td>
                                        <a href="order_details.php?order_id='.$order_id.'" class="action view-btn">View</a>
                                    </td>
                                    <td>';
                                        if ($status == "pending") {
                                            echo '<button data-order-id="'.$order_id.'" class="action in-progress-action">Put in progress</button>
                                            <button data-order-id="'.$order_id.'" class="action deliver-action hide">Delivered</button>';
                                        } elseif ($status == "in-progress") {
                                            echo '<button data-order-id="'.$order_id.'" class="action in-progress-action hide">Put in progress</button>
                                            <button data-order-id="'.$order_id.'" class="action deliver-action">Delivered</button>';
                                        }
                                        
                                        echo '<button data-order-id="'.$order_id.'" class="action remove-action">Remove</button>
                                    </td>
                                </tr>';
                        }
                        echo '
                        </table>';
                    } else {
                        echo 'No orders yet.';
                    }
                    
                    
                    ?>
                    

                        
                        
                        <!-- <tr>
                            <td>1</td>
                            <td>Muhammad Azam</td>
                            <td>azam78454@gmail.com</td>
                            <td>03333333333</td>
                            <td>Cash on Delivery</td>
                            <td>03:35 pm <b>||</b> 07 Mar, 2023</td>
                            <td>
                                <span class="status pending-status">Pending</span>
                                <span class="status in-progress-status">In Progress</span>
                                <span class="status removed-status">Removed</span>
                                <span class="status delivered-status">Delivered</span>
                            </td>
                            <td>
                                <a href="#" class="action in-progress-action">View</a>
                            </td>
                            <td>
                                <button class="action in-progress-action">Put in progress</button>
                                <button class="action deliver-action">Delivered</button>
                                <button class="action remove-action">Remove</button>
                            </td>
                        </tr> -->
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>

    // $('.dot').remove()

    // let datetime = new Date();
    // let year = datetime.getFullYear().toString()
    // let month = (datetime.getMonth() + 1).toString()
    // let date = (datetime.getDate()).toString()
    // let hour = (datetime.getHours()).toString()
    // let minute = datetime.getMinutes() < 10 ? ("0"+datetime.getMinutes()).toString() : datetime.getMinutes().toString();
    // let second = datetime.getSeconds() < 10 ? ("0"+datetime.getSeconds()).toString() : datetime.getSeconds().toString();

    // let current_datetime = parseInt(year+month+date+hour+minute+second)

    let current_datetime = <?php echo $current_datetime; ?>;
    localStorage.setItem('orders_last_seen', current_datetime);

    $('#search-order').keyup(function () {
        let search = $(this).val();

        $.ajax({
            url: 'processors/orders/search_order.php',
            type: 'POST',
            data: {
                order_type: 'pending_in-progress',
                search: search
            },
            success: function (data) {
                if (data != 0) {
                    $('.downer-section').html(data)
                } else {
                    console.log(data);
                    $('.downer-section').html(`There is no order like ${search}`)
                }
            }
        })
    })

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

                    $(this_btn).parent().prev().prev()[0].children[0].classList.add('hide')
                    $(this_btn).parent().prev().prev()[0].children[1].classList.remove('hide')
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
                    $(this_btn).parent().parent().fadeOut(200);
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
                    $(this_btn).parent().parent().fadeOut(200);
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