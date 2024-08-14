<?php

require "../../_config.php";

if (isset($_POST['address_id'])) {
    $address_id = $_POST['address_id'];

    $del_sql = "DELETE FROM `address` WHERE `id`='$address_id'";
    $del_res = mysqli_query($conn, $del_sql);

    if ($del_res) {
        echo 1;
    }
}


?>