<?php

require "../../_config.php";

if (isset($_POST['customer_id']) && $_POST['customer_id'] != "") {
    $customer_id = $_POST['customer_id'];

    $del_sql = "DELETE FROM `customers` WHERE `customer_id` = '$customer_id'";
    $del_res = mysqli_query($conn, $del_sql);

    if ($del_res) {
        $del_address_sql = "DELETE FROM `address` WHERE `customer_id` = '$customer_id'";
        $del_address_res = mysqli_query($conn, $del_address_sql);
        
        if ($del_address_res) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
    
} else {
    header("locattion: ../../account/my_profile.php");
}




?>