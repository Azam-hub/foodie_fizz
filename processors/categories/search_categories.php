<?php

require "../../_config.php";

if (isset($_POST['search'])) {

    $search = mysqli_real_escape_string($conn, $_POST['search']);
    
    if ($search == "") {
        $get_data_sql = "SELECT * FROM `categories` WHERE `status`='active' ORDER BY `category_id` DESC LIMIT 20";
    } else {
        $get_data_sql = "SELECT * FROM `categories` WHERE (`category_name` LIKE '%$search%') AND (`status`='active') ORDER BY `category_id` DESC";        
    }
    
    $get_data_res = mysqli_query($conn, $get_data_sql);
    $get_data_rows = mysqli_num_rows($get_data_res);
    
    if ($get_data_rows > 0) {
        $output = "";
        $last_category_id = "";

        while ($data = mysqli_fetch_assoc($get_data_res)) {
            // Assigning variables to data
            $category_id = $data['category_id'];
            $category_name = $data['category_name'];
            $image_path = $data['image_path'];
            
            $output .= '<a href="items.php?category_id='.$category_id.'" class="category">
                    <img src="admin_panel/'.$image_path.'" alt="Category Pic">
                    <span>'.$category_name.'</span>
                </a>';

            $last_category_id = $category_id;
        }

        $arr = [$output, $last_category_id];

        echo json_encode($arr);
    } else {
        echo 0;
    }

}

?>