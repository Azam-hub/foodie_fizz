<?php

require "../../_config.php";

session_start();
$customer_id = $_SESSION['customer_id'];
$delivery_charges = 150;

if (isset($_POST['promo_code'])) {
    $promo_code = $_POST['promo_code'];

    $get_sql = "SELECT * FROM `promo_code` WHERE `promo_code`='$promo_code' AND `status`='active'";
    $get_res = mysqli_query($conn, $get_sql);
    $get_rows = mysqli_num_rows($get_res);

    if ($get_rows > 0) {

        // get promo code data 
        $data = mysqli_fetch_assoc($get_res);
        $promo_code_id = $data['id'];
        $discount = $data['discount'];
        $discount_mode = $data['discount_mode'];
        $minimum_amount = $data['minimum_amount'];

        // Calculate grand total
        $get_cart_items_sql = "SELECT * FROM `cart` WHERE `customer_id`='$customer_id'";
        $get_cart_items_res = mysqli_query($conn, $get_cart_items_sql);

        $grand_total = 0;
        while ($cart_data = mysqli_fetch_assoc($get_cart_items_res)) {
            // Get cart rows
            $item_id = $cart_data['item_id'];
            $quantity = $cart_data['quantity'];

            // Get Item info
            $get_item_sql = "SELECT * FROM `items` WHERE `item_id`='$item_id'";
            $get_item_res = mysqli_query($conn, $get_item_sql);
            $item_data = mysqli_fetch_assoc($get_item_res);

            // assigning variables to fetched data
            $item_price = $item_data['item_price'];
            $row_total = ($item_price)*($quantity);
            $grand_total = $grand_total + $row_total;
        }

        $grand_total = $grand_total + $delivery_charges;

        if ($grand_total >= $minimum_amount) {
            
            $_SESSION['promo_code_id'] = $promo_code_id;

            if ($discount_mode == 'In Rupees (PKR)') {
                
                $to_pay_amount = $grand_total - $discount;
    
            } elseif ($discount_mode == 'In Percentage (%)') {
    
                $discount_in_rupees = ($discount / 100) * $grand_total;
                $to_pay_amount = $grand_total - round($discount_in_rupees);
            }
            
            echo $to_pay_amount;
        } else {
            echo 0;
        }
        
    } else {
        echo 0;
    }
    
}



?>