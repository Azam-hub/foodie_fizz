<?php

require "../../_config.php";

if (isset($_POST['value'])) {
    $search = mysqli_real_escape_string($conn, $_POST['value']);
    

    if (isset($_POST['customer_type']) && $_POST['customer_type'] == "banned") {
        # code...
        $get_sql = "SELECT * FROM `customers` 
        WHERE (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `mobile_no` LIKE '%$search%') AND `status` = 'banned' 
        ORDER BY `customer_id` DESC";
    } else {
        $get_sql = "SELECT * FROM `customers` 
        WHERE `name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `mobile_no` LIKE '%$search%' 
        ORDER BY `customer_id` DESC";
    }
    
    $get_res = mysqli_query($conn, $get_sql);
    $get_rows = mysqli_num_rows($get_res);
    
    if ($get_rows > 0) {
        $output = "
                    <tr>
                        <th>S. No. </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Registered at</th>
                    </tr>";
        while ($data = mysqli_fetch_assoc($get_res)) {
            // Assign variables to data fetched from database
            $customer_id = $data['customer_id'];
            $name = $data['name'];
            $email = $data['email'];
            $mobile_no = $data['mobile_no'];
            $status = $data['status'];
            $datetime = $data['registered_on'];

            // Modifying date
            $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($datetime));
            
            $output .= '<tr>
                            <td>'.$customer_id.'</td>
                            <td>'.$name.'</td>
                            <td>'.$email.'</td>
                            <td>'.$mobile_no.'</td>
                            <td>';
                            if ($status == "banned") {
                                $output .= '<span class="status banned-status">Banned</span>';
                        
                            } elseif ($status == "active") {
                                $output .= '<span class="status active-status">Active</span>';
                                
                            } elseif ($status == "pending") {
                                $output .= '<span class="status pending-status">Pending</span>';
                                
                            }
                            $output .= '</td>
                            <td>';
                            if ($status == "banned") {
                                $output .= '<button data-customer-id="'.$customer_id.'" class="action unban-action">Unban</button>';
                                
                            } elseif ($status == "active") {
                                $output .= '<button data-customer-id="'.$customer_id.'" class="action ban-action">Ban</button>';
                                
                            }
                            $output .= '</td>
                            <td>'.$modDate.'</td>
                        </tr>';
        }
        echo $output;
    } else {
        echo 'There is no name, email address, or phone number like <b><q>'.$search.'</q></b>.';
    }
    

}

?>