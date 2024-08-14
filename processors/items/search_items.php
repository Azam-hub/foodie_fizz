<?php

require "../../_config.php";

if (isset($_POST['search']) && isset($_POST['category_id'])) {

    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $url_category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    
    $get_item_sql = "SELECT * FROM `items` 
    WHERE (`item_name` LIKE '%$search%') AND (`category_id`='$url_category_id') AND (`status`='active') 
    ORDER BY `item_id` DESC";
    $get_item_res = mysqli_query($conn, $get_item_sql);
    $get_item_rows = mysqli_num_rows($get_item_res);

    if ($get_item_rows > 0) {
        $output = "";

        while ($data = mysqli_fetch_assoc($get_item_res)) {
            // Assigning variables to data 
            $item_id = $data['item_id'];
            $item_name = $data['item_name'];
            $item_price = $data['item_price'];
            $cutted_item_price = $data['cutted_item_price'];
            $image_path = $data['image_path'];                        

            $output .= '<div class="item">
                    <div class="img">
                        <img src="admin_panel/'.$image_path.'" alt="Item Pic">
                    </div>
                    <div class="item-name">'.$item_name.'</div>
                    <div class="item-price">';
                        if ($cutted_item_price == 0) {
                            $output .= 'Rs. '.$item_price;
                        } else {
                            $output .= '<div class="price before-cutted-price">Rs. '.$item_price.'</div>
                                <div class="cutted-price">Rs. '.$cutted_item_price.'</div>';
                        }
                        
                        
                    $output .= '</div>
                    <div class="counter">
                        <button class="operation decrement">-</button>
                        <span class="number">1</span>
                        <button class="operation increment">+</button>
                    </div>
                    <div class="add-to-cart">
                        <button data-item-id="'.$item_id.'" class="add-to-cart-btn">+ Add to cart</button>
                        <button data-item-id="'.$item_id.'" class="hide remove-from-cart-btn">- Remove from cart</button>
                    </div>
                </div>';
        }
        echo $output;
    } else {
        echo 'There is no item like "'.$search.'"';
    }

}

?>