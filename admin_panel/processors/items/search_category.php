<?php

require "../../_config.php";

if (isset($_POST['search'])) {

    $search = mysqli_real_escape_string($conn, $_POST['search']);
    
    $get_sql = "SELECT * FROM `categories` WHERE (`category_name` LIKE '%$search%') AND (`status`='active') ORDER BY `category_id` DESC";
    $get_res = mysqli_query($conn, $get_sql);
    $get_rows = mysqli_num_rows($get_res);
    
    if ($get_rows > 0) {
        // Display lis
        $output = "";
        while ($data = mysqli_fetch_assoc($get_res)) {
            
            // Assign variables to data fetched from database
            $category_id = $data['category_id'];
            $category_name = $data['category_name'];

            // Display data in rows
            $output .= '<li data-category-id="'.$category_id.'">'.$category_name.'</li>';
                        
        }
        echo $output;
    } else {
        echo 'There is no category like <b><q>'.$search.'</q></b>.';
    }
}
?>