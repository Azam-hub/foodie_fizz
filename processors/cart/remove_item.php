<?php

require "../../_config.php";

session_start();
$customer_id = $_SESSION['customer_id'];

if (isset($_POST['action'])) {

    $action = $_POST['action'];

    if ($action == "delete-specific-item") {
        
        $cart_id = $_POST['cart_id'];
    
        $del_sql = "DELETE FROM `cart` WHERE `id`='$cart_id'";
        $del_res = mysqli_query($conn, $del_sql);
    
        if ($del_res) {
            echo 1;
        }
    } elseif ($action == "delete-all-items") {
        $del_sql = "DELETE FROM `cart` WHERE `customer_id`='$customer_id'";
        $del_res = mysqli_query($conn, $del_sql);
    
        if ($del_res) {
            echo 1;
        }
    }
    

}

?>