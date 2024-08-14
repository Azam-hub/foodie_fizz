<?php

require "../../_config.php";

if (isset($_POST['action']) && isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action'];

    if ($action == 'confirm') {

        $update_sql = "UPDATE `table_booking` SET `status`='confirmed' WHERE `id`='$reservation_id'";
        $update_res = mysqli_query($conn, $update_sql);
        if ($update_res) {
            echo 1;
        } else {
            echo 0;
        }
        
    } elseif ($action == 'remove') {
        
        $update_sql = "UPDATE `table_booking` SET `status`='removed' WHERE `id`='$reservation_id'";
        $update_res = mysqli_query($conn, $update_sql);
        if ($update_res) {
            echo 1;
        } else {
            echo 0;
        }

    } elseif ($action == 'delete') {
        
        $del_sql = "DELETE FROM `table_booking` WHERE `id`='$reservation_id'";
        $del_res = mysqli_query($conn, $del_sql);
        if ($del_res) {
            echo 1;
        } else {
            echo 0;
        }

    }

}

?>