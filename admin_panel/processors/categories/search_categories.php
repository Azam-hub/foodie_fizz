<?php

require "../../_config.php";

if (isset($_POST['value'])) {

    $search = mysqli_real_escape_string($conn, $_POST['value']);
    
    $get_sql = "SELECT * FROM `categories` WHERE `category_name` LIKE '%$search%' ORDER BY `category_id` DESC";
    $get_res = mysqli_query($conn, $get_sql);
    $get_rows = mysqli_num_rows($get_res);
    
    if ($get_rows > 0) {
        // Display Table
        $output = "<tr>
                    <th>S. No. </th>
                    <th>Categories Name</th>
                    <th>Categories Image</th>
                    <th>No. of Items</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Added on</th>
                </tr>";
        while ($data = mysqli_fetch_assoc($get_res)) {
            
            // Assign variables to data fetched from categories table
            $category_id = $data['category_id'];
            $category_name = $data['category_name'];
            $image_path = $data['image_path'];
            $status = $data['status'];
            $added_on = $data['added_on'];

            // Accessing data from items table
            $get_item_sql = "SELECT * FROM `items` WHERE `category_id`='$category_id'";
            $get_item_res = mysqli_query($conn, $get_item_sql);
            $get_item_rows = mysqli_num_rows($get_item_res);

            // Modifying date
            $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

            // Display data in rows
            $output .= '<tr>
                    <td>'.$category_id.'.</td>
                    <td>'.$category_name.'</td>
                    <td><img src="'.$image_path.'" alt="Category Pic"></td>
                    <td>'.$get_item_rows.'</td>
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
                            
                            $output .= '<button data-category-id="'.$category_id.'" class="hide action active-action">Active</button>
                            <button data-category-id="'.$category_id.'" class="action disable-action">Disable</button>

                            <button data-category-id="'.$category_id.'" class="action delete-action">Delete</button>';
                        } elseif ($status == "disabled") {
                            
                            $output .= '<button data-category-id="'.$category_id.'" class="action active-action">Active</button>
                            <button data-category-id="'.$category_id.'" class="hide action disable-action">Disable</button>

                            <button data-category-id="'.$category_id.'" class="action delete-action">Delete</button>';
                        }
                        
                    $output .= '</td>
                    <td>'.$modDate.'</td>
                </tr>';
        }
        echo $output;
    } else {
        echo 'There is no category like <b><q>'.$search.'</q></b>.';
    }
}
?>