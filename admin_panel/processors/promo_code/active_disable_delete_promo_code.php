<?php

require "../../_config.php";

if (isset($_POST['action']) && isset($_POST['promo_code_id'])) {
    $action = $_POST['action'];
    $promo_code_id = $_POST['promo_code_id'];

    if ($action == 'active-promo-code') {

        $update_sql = "UPDATE `promo_code` SET `status`='active' WHERE `id`='$promo_code_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;
        }
        
    } elseif ($action == 'disable-promo-code') {

        $update_sql = "UPDATE `promo_code` SET `status`='disabled' WHERE `id`='$promo_code_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        } else {
            echo 0;
        }

    } elseif ($action == 'delete-promo-code') {

        $del_sql = "DELETE FROM `promo_code` WHERE `id`='$promo_code_id'";
        $del_res = mysqli_query($conn, $del_sql);

        if ($del_res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
}


?>