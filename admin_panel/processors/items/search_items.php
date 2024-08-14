<?php

require "../../_config.php";

if (isset($_POST['value'])) {

    $search = mysqli_real_escape_string($conn, $_POST['value']);
    
    $get_sql = "SELECT * FROM `items` WHERE `item_name` LIKE '%$search%' OR `item_price` LIKE '%$search%' ORDER BY `item_id` DESC";
    $get_res = mysqli_query($conn, $get_sql);
    $get_rows = mysqli_num_rows($get_res);
    
    if ($get_rows > 0) {
        // Display Table
        $output = '<tr>
                <th>S. No. </th>
                <th>Items Name</th>
                <th>Items Price (Rupees)</th>
                <th>Items Cutted Price (Rupees)</th>
                <th>Items Image</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
                <th>Added on</th>
            </tr>';
        while ($data = mysqli_fetch_assoc($get_res)) {

            // Assign variables to data fetched from items table
            $item_id = $data['item_id'];
            $item_name = $data['item_name'];
            $item_price = $data['item_price'];
            $cutted_item_price = $data['cutted_item_price'];
            $image_path = $data['image_path'];
            $category_id = $data['category_id'];
            $status = $data['status'];
            $added_on = $data['added_on'];

            // Accessing data from categories table
            $get_category_sql = "SELECT * FROM `categories` WHERE `category_id`='$category_id'";
            $get_category_res = mysqli_query($conn, $get_category_sql);
            $get_category_data = mysqli_fetch_assoc($get_category_res);
            $category_name = $get_category_data['category_name'];
            $category_status = $get_category_data['status'];

            // Modifying date
            $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

            // Display data in rows
            $output .= '<tr>
                    <td>'.$item_id.'.</td>
                    <td>'.$item_name.'</td>
                    <td>'.$item_price.'</td>
                    <td>';
                        if ($cutted_item_price == 0) {
                            $output .= '<i class="disabled-category">[No Offer]</i>';
                        } else {
                            $output .= $cutted_item_price;                                        
                        }
                        
                    $output .= '</td>
                    <td><img src="'.$image_path.'" alt="Item Pic"></td>
                    <td>';
                        if ($category_status == "active") {
                            $output .= $category_name;
                        } elseif ($category_status == "disabled") {
                            $output .= $category_name.' <i class="disabled-category">[Disabled]</i>';
                        }
                    
                    $output .= '</td>
                    <td>';
                        if ($status == "active") {
                            $output .= '<span class="status active-status">Active</span>
                            <span class="hide status disabled-status">Disabled</span>';

                        } elseif ($status == "disabled") {
                            $output .= '<span class="hide status active-status">Active</span>
                            <span class="status disabled-status">Disabled</span>';
                            
                        }
                    $output .= '</td>
                    <td>';
                        if ($status == "active") {
                                
                            $output .= '<button data-item-id="'.$item_id.'" class="hide action active-action">Active</button>
                            <button data-item-id="'.$item_id.'" class="action disable-action">Disable</button>

                            <button data-item-id="'.$item_id.'" class="action delete-action">Delete</button>';
                        } elseif ($status == "disabled") {
                            
                            $output .= '<button data-item-id="'.$item_id.'" class="action active-action">Active</button>
                            <button data-item-id="'.$item_id.'" class="hide action disable-action">Disable</button>

                            <button data-item-id="'.$item_id.'" class="action delete-action">Delete</button>';
                        }
                    $output .= '</td>
                    <td>'.$modDate.'</td>
                </tr>';
        }
        echo $output;
    } else {
        echo 'There is no item like <b><q>'.$search.'</q></b>.';
    }
}
?>