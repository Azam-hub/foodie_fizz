<?php

require "../../_config.php";


if (isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];

    $update_sql = "UPDATE `order_heads` SET `status`='removed' WHERE `id`='$order_id'";
    $update_res = mysqli_query($conn, $update_sql);

    if ($update_res) {
        echo 1;
    } else {
        echo 0;
    }
    
}

?>