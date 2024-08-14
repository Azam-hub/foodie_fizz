<?php

require "../../_config.php";

if (isset($_POST['search']) && isset($_POST['order_type'])) {
    $search = $_POST['search'];
    $order_type = $_POST['order_type'];

    if ($order_type == 'pending_in-progress') {
        
        // Getting orders according to search
        $get_order_sql = "SELECT * FROM `order_heads` WHERE 
        ((`status`='pending') OR (`status`='in-progress') OR (`status`='removed')) AND ((`id` LIKE '$search') OR (`address` LIKE '%$search%') OR (`customer_name` LIKE '%$search%') OR (`customer_email` LIKE '%$search%') OR (`customer_phone_no` LIKE '%$search%')) ORDER BY `id` DESC";

        $get_order_res = mysqli_query($conn, $get_order_sql);
        $get_order_rows = mysqli_num_rows($get_order_res);

        if ($get_order_rows > 0) {
            $output = '<table>
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <!-- <th>Email</th>
                <th>Mobile Number</th> -->
                <th>Payment Method</th>
                <th>Ordered At</th>
                <th>Status</th>
                <th>View</th>
                <th>Other Actions</th>
            </tr>';

            while ($order_head_data = mysqli_fetch_assoc($get_order_res)) {

                $order_id = $order_head_data['id'];
                $customer_name = $order_head_data['customer_name'];
                $payment_method = $order_head_data['payment_method'];
                $status = $order_head_data['status'];
                $added_on = $order_head_data['added_on'];

                $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));            
                
                $output .= '<tr>
                        <td>'.$order_id.'</td>
                        <td>'.$customer_name.'</td>
                        <!-- <td>azam78454@gmail.com</td>
                        <td>03333333333</td> -->
                        <td>'.$payment_method.'</td>
                        <td>'.$modDate.'</td>
                        <td>';
                            if ($status == "pending") {
                                $output .= '<span class="status pending-status">Pending</span>
                                <span class="status in-progress-status hide">In Progress</span>';
                            } elseif ($status == "in-progress") {
                                $output .= '<span class="status pending-status hide">Pending</span>
                                <span class="status in-progress-status">In Progress</span>';
                            } elseif ($status == "removed") {
                                $output .= '<span class="status removed-status">Removed</span>';
                            }
                        $output .= '</td>
                        <td>
                            <a href="order_details.php?order_id='.$order_id.'" class="action view-btn">View</a>
                        </td>
                        <td>';
                            if ($status == "pending") {
                                $output .= '<button data-order-id="'.$order_id.'" class="action in-progress-action">Put in progress</button>
                                <button data-order-id="'.$order_id.'" class="action deliver-action hide">Delivered</button>';
                            } elseif ($status == "in-progress") {
                                $output .= '<button data-order-id="'.$order_id.'" class="action in-progress-action hide">Put in progress</button>
                                <button data-order-id="'.$order_id.'" class="action deliver-action">Delivered</button>';
                            }
                            
                            $output .= '<button data-order-id="'.$order_id.'" class="action remove-action">Remove</button>
                        </td>
                    </tr>';
            }

            $output .= '</table>';

            echo $output;

        } else {
            echo 0;    
        }

    } elseif ($order_type == 'delivered') {

        // Getting orders according to search
        $get_order_sql = "SELECT * FROM `order_heads` WHERE 
        (`status`='delivered') AND ((`id` LIKE '$search') OR (`address` LIKE '%$search%') OR (`customer_name` LIKE '%$search%') OR (`customer_email` LIKE '%$search%') OR (`customer_phone_no` LIKE '%$search%')) ORDER BY `id` DESC";

        $get_order_res = mysqli_query($conn, $get_order_sql);
        $get_order_rows = mysqli_num_rows($get_order_res);

        if ($get_order_rows > 0) {
            $output = '<table>
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <!-- <th>Email</th>
                <th>Mobile Number</th> -->
                <th>Payment Method</th>
                <th>Ordered At</th>
                <th>Status</th>
                <th>View</th>
                <th>Other Actions</th>
            </tr>';

            while ($order_head_data = mysqli_fetch_assoc($get_order_res)) {

                $order_id = $order_head_data['id'];
                $customer_name = $order_head_data['customer_name'];
                $payment_method = $order_head_data['payment_method'];
                $status = $order_head_data['status'];
                $added_on = $order_head_data['added_on'];

                $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));            
                
                $output .= '<tr>
                        <td>'.$order_id.'</td>
                        <td>'.$customer_name.'</td>
                        <!-- <td>azam78454@gmail.com</td>
                        <td>03333333333</td> -->
                        <td>'.$payment_method.'</td>
                        <td>'.$modDate.'</td>
                        <td><span class="status delivered-status">Delivered</span></td>
                        <td>
                            <a href="order_details.php?order_id='.$order_id.'" class="action view-btn">View</a>
                        </td>
                        <td><button data-order-id="'.$order_id.'" class="action remove-action">Remove</button></td>
                    </tr>';
            }

            $output .= '</table>';

            echo $output;

        } else {
            echo 0;    
        }
        
    }
    
    
}

?>