<?php

require "../../_config.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $order_id = $_POST['order_id'];

    if ($action == "in-progress") {
        $update_sql = "UPDATE `order_heads` SET `status`='in-progress' WHERE `id`='$order_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;
        }
        
    } elseif ($action == "deliver") {
        $update_sql = "UPDATE `order_heads` SET `status`='delivered' WHERE `id`='$order_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;
        }
        
    } elseif ($action == "remove") {

        // Deleting order head
        $del_order_head_sql = "DELETE FROM `order_heads` WHERE `id`='$order_id'";
        $del_order_head_res = mysqli_query($conn, $del_order_head_sql);

        if ($del_order_head_res) {
            // Deleting order items
            $del_order_items_sql = "DELETE FROM `ordered_items` WHERE `order_id`='$order_id'";
            $del_order_items_res = mysqli_query($conn, $del_order_items_sql);

            if ($del_order_items_res) {
                echo 1;
            } else {
                echo 0;
            }
            
        } else {
            echo 0;
        }
    }
    
}

?>