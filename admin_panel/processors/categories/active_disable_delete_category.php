<?php

require "../../_config.php";

if (isset($_POST['action']) && isset($_POST['category_id'])) {
    // Fetching data
    $action = $_POST['action'];
    $category_id = $_POST['category_id'];

    if ($action == "disable-category") {
        // Updating database
        $update_sql = "UPDATE `categories` SET `status` = 'disabled' WHERE `category_id` = '$category_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
        
    } elseif ($action == "active-category") {
        // Updating database
        $update_sql = "UPDATE `categories` SET `status` = 'active' WHERE `category_id` = '$category_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
    } elseif ($action == "delete-category") {
        // Updating database
        $update_sql = "DELETE FROM `categories` WHERE `category_id` = '$category_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;            
        }
    }
}




?>