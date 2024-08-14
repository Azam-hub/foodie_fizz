<?php

require "../../_config.php";

if (isset($_POST['action']) && isset($_POST['customer_id'])) {
    // Fetching data
    $action = $_POST['action'];
    $customer_id = $_POST['customer_id'];

    if ($action == "ban-customer") {
        // Updating database
        $update_sql = "UPDATE `customers` SET `status` = 'banned' WHERE `customer_id` = '$customer_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
        
    } elseif ($action == "unban-customer") {
        // Updating database
        $update_sql = "UPDATE `customers` SET `status` = 'active' WHERE `customer_id` = '$customer_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
    }
}




?>