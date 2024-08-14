<?php

require "../../_config.php";

$delivery_charges = 150;

if (isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];

    $get_order_sql = "SELECT * FROM `order_heads` WHERE `id`='$order_id'";
    $get_order_res = mysqli_query($conn, $get_order_sql);
    $get_order_rows = mysqli_num_rows($get_order_res);

    if ($get_order_rows > 0) {
        
        $order_data = mysqli_fetch_assoc($get_order_res);
        
        $payment_method = $order_data['payment_method'];
        $address = $order_data['address'];
        $promo_code_id = $order_data['promo_code_id'];
        $status = $order_data['status'];
        $added_on = $order_data['added_on'];

        $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

        echo '<div class="modal-div">
        <i class="fa-solid fa-xmark cross-icon"></i>
        <h1>Order Details</h1>
        <div class="order-details">
            <h4>Order Details</h4>
            <div class="details">
                <div class="left">
                    <p>Order ID: <span>'.$order_id.'</span></p>
                    <p>Order Date: <span>'.$modDate.'</span></p>';

                    if ($status == 'pending') {
                        echo '<p>Order Status: <span class="status pending-status">Pending</span></p>';
                        echo '<p>Actions: </p>
                            <div class="action-buttons">
                                <button data-order-id="'.$order_id.'" class="action remove-action">Remove</button>
                            </div>';
                    } elseif ($status == 'in-progress') {
                        echo '<p>Order Status: <span class="status in-progress-status">In Progress</span></p>';
                        echo '<p>Actions: </p>
                            <div class="action-buttons">
                                <button data-order-id="'.$order_id.'" class="action remove-action">Remove</button>
                            </div>';
                    } elseif ($status == 'delivered') {
                        echo '<p>Order Status: <span class="status delivered-status">Delivered</span></p>';    
                    } elseif ($status == 'removed') {
                        echo '<p>Order Status: <span class="status removed-status">Removed</span></p>';    
                    }

                    
                echo '</div>
                <div class="right">
                    <p>Payment Method: <span>'.$payment_method.'</span></p>
                    <p>Delivery Charges: <span>Rs. '.$delivery_charges.'</span></p>';

                    if ($promo_code_id == "") {
                        echo '<p>Promo Code: <span>No Promo Code</span></p>';
                    } else {
                        $get_promo_code_sql = "SELECT * FROM `promo_code` WHERE `id`='$promo_code_id'";
                        $get_promo_code_res = mysqli_query($conn, $get_promo_code_sql);
                        $promo_code_data = mysqli_fetch_assoc($get_promo_code_res);

                        $promo_code = $promo_code_data['promo_code'];
                        $discount = $promo_code_data['discount'];
                        $discount_mode = $promo_code_data['discount_mode'];

                        echo '<p>Promo Code: <span>'.$promo_code.'</span></p>
                        <p>Discount: <span>'.$discount.' ('.$discount_mode.')</span></p>';
                    }

                    echo '<p>Address: <span>'.$address.'</span></p>
                </div>
            </div>
        </div>';

        echo '<div class="order-items">
            <h4>Ordered Items</h4>
            <table>
                <tr>
                    <th>Item ID</th>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>';

                $get_ordered_items_sql = "SELECT * FROM `ordered_items` WHERE `order_id`='$order_id'";
                $get_ordered_items_res = mysqli_query($conn, $get_ordered_items_sql);

                $grand_total = 0;
                while ($ordered_items_data = mysqli_fetch_assoc($get_ordered_items_res)) {
                    $quantity = $ordered_items_data['quantity'];
                    $item_id = $ordered_items_data['item_id'];

                    $get_item_sql = "SELECT * FROM `items` WHERE `item_id`='$item_id'";
                    $get_item_res = mysqli_query($conn, $get_item_sql);
                    $item_data = mysqli_fetch_assoc($get_item_res);

                    $image_path = $item_data['image_path'];
                    $item_name = $item_data['item_name'];
                    $item_price = $item_data['item_price'];

                    echo '<tr>
                        <td>'.$item_id.'.</td>
                        <td><img src="admin_panel/'.$image_path.'" alt="Item Pic"></td>
                        <td>'.$item_name.'</td>
                        <td>Rs. '.$item_price.'</td>
                        <td>'.$quantity.'</td>
                        <td>Rs. '.$row_total = $item_price * $quantity.'</td>
                    </tr>';

                    $grand_total = $grand_total + ($item_price * $quantity);   
                }
                $grand_total = $grand_total + $delivery_charges;

            echo '
            <tr>
                <td><b>Total Amount :</b></td>
                <td></td>
                <td></td>
                <td></td>';
                if ($promo_code_id != "") {

                    echo '<td><b>'.$promo_code.'</b>: '.$discount.' ('.$discount_mode.')</td>';
                    
                    // Applying promo code
                    if ($discount_mode == 'In Rupees (PKR)') {
                        $to_pay_amount = $grand_total - $discount;
                    } elseif ($discount_mode == 'In Percentage (%)') {
                        $discount_in_rupees = ($discount / 100) * $grand_total;
                        $to_pay_amount = $grand_total - round($discount_in_rupees);
                    }

                    echo '<td>
                        <span style="font-size: 14px; text-decoration: line-through;">Rs. '.$grand_total.'</span>
                        <b>Rs. '.$to_pay_amount.'</b>
                    </td>';
                } else {
                    echo '<td></td>
                    <td><b>Rs. '.$grand_total.'</b></td>';
                }
            echo '</tr>
            </table>
        </div>
        </div>';
        
    } else {
        echo 0;
    }
    
}


?>