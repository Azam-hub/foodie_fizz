<?php

use function PHPSTORM_META\map;

require "../../_config.php";

date_default_timezone_set("Asia/Karachi");
$datetime = date("Y-m-d H:i:s");

session_start();
if (!(isset($_SESSION['user_logged_in'])) || $_SESSION['user_logged_in'] == false) {
    header("location: index.php");
} else {
    $customer_id = $_SESSION['customer_id'];
}

if (isset($_POST['action'])) {

    $address_id = $_POST['address_id'];

    // Getting Address from database
    $get_address_sql = "SELECT * FROM `address` WHERE `id`='$address_id'";
    $get_address_res = mysqli_query($conn, $get_address_sql);
    $address_data = mysqli_fetch_assoc($get_address_res);
    $address = $address_data['address'];

    // Getting customer details from database
    $get_customer_sql = "SELECT * FROM `customers` WHERE `customer_id`='$customer_id'";
    $get_customer_res = mysqli_query($conn, $get_customer_sql);
    $customer_data = mysqli_fetch_assoc($get_customer_res);
    $customer_name = $customer_data['name'];
    $customer_email = $customer_data['email'];
    $customer_mobile_no = $customer_data['mobile_no'];

    // Checking if promo code applied or not
    if (isset($_SESSION['promo_code_id']) && $_SESSION['promo_code_id'] != null) {
        $promo_code_id = $_SESSION['promo_code_id'];

        $get_promo_code_sql = "SELECT * FROM `promo_code` WHERE `id`='$promo_code_id'";
        $get_promo_code_res = mysqli_query($conn, $get_promo_code_sql);
        $get_promo_code_rows = mysqli_num_rows($get_promo_code_res);

        if ($get_promo_code_rows > 0) {
            $promo_code_data = mysqli_fetch_assoc($get_promo_code_res);
            $promo_code_status = $promo_code_data['status'];

            if ($promo_code_status != 'active') {
                $promo_code_id = null;
            }
            
        } else {
            $promo_code_id = null;
            
        }
        

    } else {
        $promo_code_id = null;
    }

    // Getting last row id
    $get_last_row_id_sql = "SELECT * FROM `order_heads` ORDER BY `id` DESC LIMIT 1";
    $get_last_row_id_res = mysqli_query($conn, $get_last_row_id_sql);
    $get_last_row_id_rows = mysqli_num_rows($get_last_row_id_res);

    if ($get_last_row_id_rows > 0) {
        $get_last_row_id_data = mysqli_fetch_assoc($get_last_row_id_res);
        $last_row_id = $get_last_row_id_data['id'];
        $order_head_id = $last_row_id + 1;
    } else {
        $order_head_id = 1;
    }
    

    // Inserting order head into database
    $insert_order_head_sql = "INSERT INTO `order_heads` (`id`, `payment_method`, `address`, `customer_id`, `customer_name`, `customer_email`, `customer_phone_no`, `promo_code_id`, `status`, `added_on`) 
                    VALUES ('$order_head_id', 'Cash on Delivery', '$address', '$customer_id', '$customer_name', '$customer_email', '$customer_mobile_no', '$promo_code_id', 'pending', '$datetime')";
    $insert_order_head_res = mysqli_query($conn, $insert_order_head_sql);

    if ($insert_order_head_res) {
        
        // Inserting ordered items
        $get_cart_items_sql = "SELECT * FROM `cart` WHERE `customer_id`='$customer_id'";
        $get_cart_items_res = mysqli_query($conn, $get_cart_items_sql);

        $is_items_insert = true;
        
        while ($cart_data = mysqli_fetch_assoc($get_cart_items_res)) {
            $item_id = $cart_data['item_id'];
            $quantity = $cart_data['quantity'];

            $insert_ordered_items_sql = "INSERT INTO `ordered_items` (`item_id`, `quantity`, `order_id`) VALUES 
            ('$item_id', '$quantity', '$order_head_id')";
            $insert_ordered_items_res = mysqli_query($conn, $insert_ordered_items_sql);

            if ($insert_ordered_items_res != true) {

                $is_items_insert = false;
                break;
            }
        }

        // Checking if all items inserted or not
        if ($is_items_insert) {
                
            // Deleting items from cart
            $del_sql = "DELETE FROM `cart` WHERE `customer_id`='$customer_id'";
            $del_res = mysqli_query($conn, $del_sql);

            $_SESSION['promo_code_id'] = null;

            if ($del_res) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
        
    } else {
        echo 0;
    }
    
} else {
    echo 0;
}



?>