<?php

require "../../_config.php";

session_start();

date_default_timezone_set("Asia/Karachi");
$datetime = date("Y-m-d H:i:s");

if (isset($_SESSION['user_logged_in']) && ($_SESSION['user_logged_in'] == true)) {

    $customer_id = $_SESSION['customer_id'];
    
    if (isset($_POST['action']) && isset($_POST['item_id'])) {
    
        $action = $_POST['action'];
        $item_id = $_POST['item_id'];
        
        if ($action == 'add-item') {
            $quantity = $_POST['quantity'];

            // Updating number of order of this item
            $get_item_sql = "SELECT * FROM `items` WHERE `item_id`='$item_id'";
            $get_item_res = mysqli_query($conn, $get_item_sql);
            $get_item_data = mysqli_fetch_assoc($get_item_res);
            $number_of_order = $get_item_data['number_of_order'];
            $updated_number_of_order = $number_of_order + 1;
            $update_number_of_order_sql = "UPDATE `items` SET `number_of_order`='$updated_number_of_order' WHERE `item_id`='$item_id'";
            $update_number_of_order_res = mysqli_query($conn, $update_number_of_order_sql);
    
            $insert_sql = "INSERT INTO `cart` (`customer_id`, `item_id`, `quantity`, `added_on`) 
            VALUES ('$customer_id', '$item_id', '$quantity', '$datetime')";
            $insert_res = mysqli_query($conn, $insert_sql);

            if ($insert_res) {
                echo 1;
            }
        } elseif ($action == 'remove-item') {
            $del_sql = "DELETE FROM `cart` WHERE `item_id`='$item_id' AND `customer_id`='$customer_id'";
            $del_res = mysqli_query($conn, $del_sql);

            if ($del_res) {
                echo 1;
            }
        }
    }
} else {
    echo 0;
}



?>