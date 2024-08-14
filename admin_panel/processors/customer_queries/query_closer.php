<?php

require "../../_config.php";

if (isset($_POST['action']) && isset($_POST['query_id'])) {
    $action = $_POST['action'];
    $query_id = $_POST['query_id'];

    if ($action == "close-query") {
        $update_sql = "UPDATE `queries` SET `status`='closed' WHERE `id`='$query_id'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            echo 1;
        }
    } else if ($action == "remove-query") {
        
        $del_sql = "DELETE FROM `queries` WHERE `id`='$query_id'";
        $del_res = mysqli_query($conn, $del_sql);

        if ($del_res) {
            echo 1;
        }
    }
}


?>