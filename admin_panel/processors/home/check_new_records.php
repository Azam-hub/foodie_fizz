<?php

require "../../_config.php";

if (isset($_POST['orders_last_seen']) && isset($_POST['queries_last_seen']) && isset($_POST['reservation_last_seen'])) {
    $orders_last_seen = $_POST['orders_last_seen'];
    $queries_last_seen = $_POST['queries_last_seen'];
    $reservation_last_seen = $_POST['reservation_last_seen'];

    // Getting orders more than seen time
    $get_orders_sql = "SELECT * FROM `order_heads` ORDER BY `id` DESC";
    $get_orders_res = mysqli_query($conn, $get_orders_sql);
    $get_orders_rows = mysqli_num_rows($get_orders_res);

    $unseen_orders = 0;
    if ($get_orders_rows > 0) {
        $orders_output = "";
        while ($orders_data = mysqli_fetch_assoc($get_orders_res)) {
            $orders_db_datetime = $orders_data['added_on'];
            $orders_datetime = date ('YnjHis', strtotime($orders_db_datetime));

            if ($orders_datetime < $orders_last_seen) {
                continue;
            }
            $unseen_orders = $unseen_orders + 1;

            $order_id = $orders_data['id'];
            $customer_name = $orders_data['customer_name'];

            $orders_output .= '
                    <tr>
                        <td>'.$order_id.'.</td>
                        <td>You have new order from <b><q>'.$customer_name.'</q></b></td>
                        <td><a href="orders.php#'.$order_id.'" class="action view-btn">View</a></td>
                    </tr>';

        }
        // echo $output;
    }




    // Getting queries more than seen time
    $get_queries_sql = "SELECT * FROM `queries` ORDER BY `id` DESC";
    $get_queries_res = mysqli_query($conn, $get_queries_sql);
    $get_queries_rows = mysqli_num_rows($get_queries_res);

    $unseen_queries = 0;
    if ($get_queries_rows > 0) {
        $queries_output = "";
        while ($queries_data = mysqli_fetch_assoc($get_queries_res)) {
            $queries_db_datetime = $queries_data['added_on'];
            $queries_datetime = date ('YnjHis', strtotime($queries_db_datetime));

            if ($queries_datetime < $queries_last_seen) {
                continue;
            }
            $unseen_queries = $unseen_queries + 1;

            $query_id = $queries_data['id'];
            $name = $queries_data['name'];

            $queries_output .= '
                    <tr>
                        <td>'.$query_id.'.</td>
                        <td>You have new query from <b><q>'.$name.'</q></b></td>
                        <td><a href="customers_queries.php#'.$query_id.'" class="action view-btn">View</a></td>
                    </tr>';
        
        }
        // echo $queries_output;
    }




    // Getting reservation more than seen time
    $get_reservations_sql = "SELECT * FROM `table_booking` ORDER BY `id` DESC";
    $get_reservations_res = mysqli_query($conn, $get_reservations_sql);
    $get_reservations_rows = mysqli_num_rows($get_reservations_res);

    $unseen_reservations = 0;
    if ($get_reservations_rows > 0) {
        $reservations_output = "";
        while ($reservations_data = mysqli_fetch_assoc($get_reservations_res)) {
            $reservations_db_datetime = $reservations_data['added_on'];
            $reservations_datetime = date ('YnjHis', strtotime($reservations_db_datetime));

            if ($reservations_datetime < $reservation_last_seen) {
                continue;
            }
            $unseen_reservations = $unseen_reservations + 1;

            $reservation_id = $reservations_data['id'];
            $name = $reservations_data['name'];

            $reservations_output .= '
                    <tr>
                        <td>'.$reservation_id.'.</td>
                        <td>You have new Reservation from <b><q>'.$name.'</q></b></td>
                        <td><a href="table_booking.php#'.$reservation_id.'" class="action view-btn">View</a></td>
                    </tr>';

        }
        // echo $reservations_output;
    }

    $arr = [$orders_output, $queries_output, $reservations_output, $unseen_orders, $unseen_queries, $unseen_reservations];
    echo json_encode($arr);

}

?>