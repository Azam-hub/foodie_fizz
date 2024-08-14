<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
$datetime = date("Y-m-d H:i:s");

$msg = "";

if (isset($_POST['item-submit'])) {
    // Getting fields input
    $item_name = mysqli_real_escape_string($conn, $_POST['item-name']);
    $item_price = mysqli_real_escape_string($conn, $_POST['item-price']);
    $cutted_item_price = mysqli_real_escape_string($conn, $_POST['cutted-item-price']);
    $category_id = $_POST['category-id'];
    $item_image = $_FILES['item-image'];

    // Accessing arrays values
    $item_image_name = mysqli_real_escape_string($conn, $item_image["name"]);
    $item_image_type = $item_image["type"];
    $item_image_size= $item_image["size"];
    $item_image_tmp_name = $item_image["tmp_name"];

    // Check if fields are filled or not
    if ($item_name == "" || $item_price == "" || $item_image_name == "") {
        $msg = danger_msg("Category name, price and image are required.");
    } else {
        // Getting extension of file
        $extension = pathinfo($item_image_name, PATHINFO_EXTENSION);
        // File formats array
        $img_formats_arr = ["jpg", "jpeg", "gif", "png", "tiff", "tif"];

        // Checking file is image or not
        if (!in_array($extension, $img_formats_arr)) {
            $msg = danger_msg("Please select an image of <b>jpg</b>, <b>jpeg</b>, <b>gif</b>, <b>png</b>, <b>tiff</b> or <b>tif</b> format.");
        // Checking file size
        } elseif ($item_image_size > 50000000) {
            $msg = danger_msg("Please select image file of size less than 50MB.");
        } else {

            $for_path_datetime = date("H_i_s-Y_m_d");
            $path = "src/dynamic/items_image/".$item_name."@".$for_path_datetime.".". $extension;
            $upload = move_uploaded_file($item_image_tmp_name, $path);

            if (!$upload) {
                $msg = danger_msg("Image could not upload. Please try again later.");
            } else {
                if ($cutted_item_price == "") {
                    $insert_val = 0;
                } else {
                    $insert_val = $cutted_item_price;
                }
                
                $insert_sql = "INSERT INTO `items` (`item_name`, `item_price`, `cutted_item_price`, `image_path`, `category_id`, `number_of_order`, `status`, `added_on`) 
                VALUES ('$item_name', '$item_price', '$insert_val', '$path', '$category_id', 0, 'active', '$datetime')";
                $insert_res = mysqli_query($conn, $insert_sql);
            
                if ($insert_res) {
                    $msg = success_msg("<b><q>".$item_name."</b></q> Item has been added.");
                } else {
                    $msg = danger_msg("Something went wrong! Please try again later.");
                }
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel - Foodie Fizz</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Pattaya&family=Racing+Sans+One&display=swap" rel="stylesheet">

    <!-- Fontawesome Link -->
    <link rel="stylesheet" href="fontawesome_icon/css/all.min.css">

    <!-- Local Links -->
    <link rel="shortcut icon" href="src/static/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/_utils.css">
    <link rel="stylesheet" href="css/_sidebar_header.css">
    
    <link rel="stylesheet" href="css/items.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_sidebar.php"; ?>
    
    <div class="main-container">
        
        <?php include "_header.php"; ?>
        <?php echo $msg; ?>

        <div class="section">
            <div class="section-1"> 
                <div class="upper-section">
                    <div class="left">
                        <h2>Add Item</h2>
                    </div>
                </div>
                <div class="downer-section">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="upper-form">
                            <div class="item-name-div">
                                <label for="item-name">Enter Item Name</label>
                                <input name="item-name" type="text" id="item-name" placeholder="Enter Item Name">
                            </div>
                            <div class="item-price-div">
                                <label for="item-price">Enter Item Price</label>
                                <input name="item-price" type="number" id="item-price" placeholder="Enter Item Price">
                            </div>
                            <div class="item-price-div">
                                <label for="item-price">Enter Cutted Item Price</label>
                                <span class="small-info">(Leave empty if no offer)</span>
                                <input name="cutted-item-price" type="number" id="item-price" placeholder="Enter Cutted Item Price">
                            </div>
                        </div>

                        <div class="item-img-div">
                            <label for="item-image">Select Item Image</label>
                            <input type="file" name="item-image" id="item-image">
                            <img id="preview_img_tag" src="src/static/default_image.PNG" alt="" srcset="">
                        </div>

                        <div class="select-category-div">
                            <label for="select-category">Select Category</label>
                            <!-- <select id="select-category">
                                <option value="">-- Select Category --</option>
                                <option value="">ss</option>
                                <option value="">ddd</option>
                            </select> -->
                            <input type="hidden" id="category-id" name="category-id">
                            <div class="select-box">
                                <button class="show_hide_list_btn">-- Select Category -- <i class="fa-solid fa-angle-down"></i></button>
                                <div class="select-category-list list">
                                    <input type="text" class="search-category" placeholder="Search Category">
                                    <ul>
                                        <?php
                                        
                                        $get_sql = "SELECT * FROM `categories` WHERE (`status`='active') ORDER BY `category_id` DESC";
                                        $get_res = mysqli_query($conn, $get_sql);
                                        $get_rows = mysqli_num_rows($get_res);
                                        
                                        if ($get_rows > 0) {
                                            // Display lis
                                            while ($data = mysqli_fetch_assoc($get_res)) {
                                                
                                                // Assign variables to data fetched from database
                                                $category_id = $data['category_id'];
                                                $category_name = $data['category_name'];

                                                // Display data in rows
                                                echo '<li data-category-id="'.$category_id.'">'.$category_name.'</li>';
                                                            
                                            }
                                        } else {
                                            echo 'There is no cateegory like <b><q>'.$search.'</q></b>.';
                                        }
                                        
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="btn">
                            <button type="submit" name="item-submit">Add Item</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="section-2">
                <div class="upper-section">
                    <div class="left">
                        <h2>All Items</h2>                        
                    </div>
                    <div class="right">
                        <div class="select-category-div">
                            <label>Filter by Category</label>
                            <!-- <select id="select-category">
                                <option value="">-- Select Category --</option>
                                <option value="">ss</option>
                                <option value="">ddd</option>
                            </select> -->
                            <div class="select-box">
                                <button class="show_hide_list_btn">-- Select Category -- <i class="fa-solid fa-angle-down"></i></button>
                                <div class="filter-category-list list">
                                    <input type="text" class="search-category" placeholder="Search Category">
                                    <ul>
                                        <?php
                                        
                                        $get_sql = "SELECT * FROM `categories` WHERE (`status`='active') ORDER BY `category_id` DESC";
                                        $get_res = mysqli_query($conn, $get_sql);
                                        $get_rows = mysqli_num_rows($get_res);
                                        
                                        if ($get_rows > 0) {
                                            // Display lis
                                            while ($data = mysqli_fetch_assoc($get_res)) {
                                                
                                                // Assign variables to data fetched from database
                                                $category_id = $data['category_id'];
                                                $category_name = $data['category_name'];
    
                                                // Display data in rows
                                                echo '<li data-category-id="'.$category_id.'">'.$category_name.'</li>';
                                                            
                                            }
                                        } else {
                                            echo 'There is no cateegory like <b><q>'.$search.'</q></b>.';
                                        }
                                        
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="search-item">
                            <label for="search-item">Search Item</label>
                            <input type="text" id="search-item" placeholder="Search Item">
                        </div>

                    </div>
                </div>
                <div class="downer-section">
                    <?php
                    
                    // Fetching all data
                    $get_data_sql = "SELECT * FROM `items` ORDER BY `item_id` DESC";
                    $get_data_res = mysqli_query($conn, $get_data_sql);
                    $get_data_rows = mysqli_num_rows($get_data_res);

                    // Check any customer exist or not
                    if ($get_data_rows > 0) {
                        // Display Table
                        echo '<table>
                                <tr>
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
                        while ($data = mysqli_fetch_assoc($get_data_res)) {
                    
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
                            echo '<tr>
                                    <td>'.$item_id.'.</td>
                                    <td>'.$item_name.'</td>
                                    <td>'.$item_price.'</td>
                                    <td>';
                                    if ($cutted_item_price == 0) {
                                        echo '<i class="disabled-category">[No Offer]</i>';
                                    } else {
                                        echo $cutted_item_price;                                        
                                    }
                                    
                                    echo '</td>
                                    <td><img src="'.$image_path.'" alt="Item Pic"></td>
                                    <td>';
                                        if ($category_status == "active") {
                                            echo $category_name;
                                        } elseif ($category_status == "disabled") {
                                            echo $category_name.' <i class="disabled-category">[Disabled]</i>';
                                        }
                                        
                                    echo '</td>
                                    <td>';
                                        if ($status == "active") {
                                            echo '<span class="status active-status">Active</span>
                                            <span class="hide status disabled-status">Disabled</span>';

                                        } elseif ($status == "disabled") {
                                            echo '<span class="hide status active-status">Active</span>
                                            <span class="status disabled-status">Disabled</span>';
                                            
                                        }
                                    echo '</td>
                                    <td>';
                                        if ($status == "active") {
                                                
                                            echo '<button data-item-id="'.$item_id.'" class="hide action active-action">Active</button>
                                            <button data-item-id="'.$item_id.'" class="action disable-action">Disable</button>

                                            <button data-item-id="'.$item_id.'" class="action delete-action">Delete</button>';
                                        } elseif ($status == "disabled") {
                                            
                                            echo '<button data-item-id="'.$item_id.'" class="action active-action">Active</button>
                                            <button data-item-id="'.$item_id.'" class="hide action disable-action">Disable</button>

                                            <button data-item-id="'.$item_id.'" class="action delete-action">Delete</button>';
                                        }
                                    echo '</td>
                                    <td>'.$modDate.'</td>
                                </tr>';
                        }
                        echo '</table>';
                    } else {
                        echo "No items yet.";
                    }
                    
                    ?>
                    <!-- <table>
                        <tr>
                            <th>S. No. </th>
                            <th>Items Name</th>
                            <th>Items Price (Rupees)</th>
                            <th>Items Image</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Added on</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Cheese Pizza</td>
                            <td>2000</td>
                            <td><img src="../_test_img/Beef Biyani.jpg" alt="Item Pic"></td>
                            <td>Pizza</td>
                            <td>
                                <span class="status active-status">Active</span>
                                <span class="status disabled-status">Disabled</span>
                            </td>
                            <td>
                                <button class="action active-action">Active</button>
                                <button class="action disable-action">Disable</button>
                                <button class="action delete-action">Delete</button>
                            </td>
                            <td>03:35 pm <b>||</b> 07 Mar, 2023</td>
                        </tr>
                    </table> -->
                </div>
            </div>

        </div>
    </div>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script type="text/javascript">

    // Showing preview of image
    var preview_image = document.getElementById('preview_img_tag')

    $('#item-image').change(function (e) {
        var image_type = URL.createObjectURL(e.target.files[0]);
        console.log(image_type)
        preview_image.setAttribute('src', image_type)

    })

    // Select Category Methods
    $(".select-box button").click(function (e) {
        e.preventDefault()
        $(this).next().toggle()
    })
    $('body').click(function(evt){
        if(evt.target.classList.contains('list') || evt.target.classList.contains('show_hide_list_btn')) {
            return;
            
        }
        if($(evt.target).closest('.list, .show_hide_list_btn').length) {
            return;             
        }
        $('.select-box .list').hide()
    });

    $(document).on('click', ".select-category-list li", function () {
        var category_id = $(this).data("category-id")
        var selected_li_text = $(this).text()

        $('#category-id').val(category_id)

        $('.list').hide()
        $(".select-category-list").prev().html(`${selected_li_text} <i class="fa-solid fa-angle-down"></i>`)
    })
    
    $(".search-category").keyup(function () {
        var search = $(this).val()
        var this_input = $(this)
        
        $.ajax({
            url: 'processors/items/search_category.php',
            type: 'POST',
            data: {
                search: search
            },
            success: function (data) {
                // console.log(data);
                $(this_input).next().html(data)
            }
        })
    })

    
    
    // Items Action 
    $(document).on('click', ".filter-category-list li", function () {
        var category_id = $(this).data("category-id")
        var selected_li_text = $(this).text()

        $('.list').hide()
        $(".filter-category-list").prev().html(`${selected_li_text} <i class="fa-solid fa-angle-down"></i>`)

        $.ajax({
            url: 'processors/items/filter_items.php',
            type: 'POST',
            data: {
                category_id: category_id
            },
            success: function (data) {
                // console.log(data);
                if (data == 0) {
                    $('table').html(`There is no item of <b><q>${selected_li_text}</q></b> category.`)
                    
                } else {
                    
                    $('table').html(data)
                }
            }
        })

    })
    
    $(document).on('click', '.disable-action', function () {
        let item_id = $(this).data("item-id")
        
        let this_btn = $(this);
        let previous_td = $(this).parent().prev()[0].children
        
        $.ajax({
            url: 'processors/items/active_disable_delete_item.php',
            type: 'POST',
            data: {
                action: "disable-item",
                item_id: item_id
            },
            success: function (data) {
                if (data == 1) {
                    // location.href = location.href
                    $(this_btn).hide()
                    $(this_btn).prev().show()

                    $(previous_td[0]).hide()
                    $(previous_td[1]).show()

                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.active-action', function () {
        let item_id = $(this).data("item-id")
        
        let this_btn = $(this);
        let previous_td = $(this).parent().prev()[0].children
        
        $.ajax({
            url: 'processors/items/active_disable_delete_item.php',
            type: 'POST',
            data: {
                action: "active-item",
                item_id: item_id
            },
            success: function (data) {
                if (data == 1) {
                    // location.href = location.href
                    $(this_btn).hide()
                    $(this_btn).next().show()

                    $(previous_td[0]).show()
                    $(previous_td[1]).hide()

                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.delete-action', function () {
        let item_id = $(this).data("item-id")
        
        let parent_tr = $(this).parent().parent()

        $.ajax({
            url: 'processors/items/active_disable_delete_item.php',
            type: 'POST',
            data: {
                action: "delete-item",
                item_id: item_id
            },
            success: function (data) {
                if (data == 1) {
                    $(parent_tr).remove()
                } else {
                    console.log(data);
                }
            }
        })
    })

    $("#search-item").keyup(function () {
        var value = $(this).val()

        $.ajax({
            url: 'processors/items/search_items.php',
            type: 'POST',
            data: {
                value: value
            },
            success: function (data) {
                // console.log(data);
                $('table').html(data)
            }
        })
    })

</script>

<!-- Sidebar Hide/Show -->
<script src="js/sidebar_show_hide.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>