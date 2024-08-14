<?php

require "../../_config.php";

if (isset($_POST['action']) && isset($_POST['item_id'])) {
    // Fetching data
    $action = $_POST['action'];
    $item_id = $_POST['item_id'];

    if ($action == "disable-item") {
        // Updating database
        $update_sql = "UPDATE `items` SET `status` = 'disabled' WHERE `item_id` = '$item_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
        
    } elseif ($action == "active-item") {
        // Updating database
        $update_sql = "UPDATE `items` SET `status` = 'active' WHERE `item_id` = '$item_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
    } elseif ($action == "delete-item") {
        // Updating database
        $update_sql = "DELETE FROM `items` WHERE `item_id` = '$item_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
    }
}




?>