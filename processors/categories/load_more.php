<?php

require "../../_config.php";

if (isset($_POST['last_category_id'])) {
    $last_category_id = $_POST['last_category_id'];

    $get_next_sql = "SELECT * FROM `categories` 
    WHERE (`category_id` < '$last_category_id') AND (`status`='active') ORDER BY `category_id` DESC LIMIT 20";
    $get_next_res = mysqli_query($conn, $get_next_sql);
    $get_next_rows = mysqli_num_rows($get_next_res);

    if ($get_next_rows > 0) {
        $last_category_id = "";
        $output = "";

        while ($data = mysqli_fetch_assoc($get_next_res)) {
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