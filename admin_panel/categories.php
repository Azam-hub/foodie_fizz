<?php

date_default_timezone_set("Asia/Karachi");

require "_config.php";
$msg = "";
$datetime = date("Y-m-d H:i:s");

if (isset($_POST['category-submit'])) {
    // Getting fields input
    $category_name = mysqli_real_escape_string($conn, $_POST['category-name']);
    $category_image = $_FILES['category-image'];

    // Accessing arrays values
    $category_image_name = mysqli_real_escape_string($conn, $category_image["name"]);
    $category_image_type = $category_image["type"];
    $category_image_size= $category_image["size"];
    $category_image_tmp_name = $category_image["tmp_name"];

    // Check if fields are filled or not
    if ($category_name == "" || $category_image_name == "") {
        $msg = danger_msg("Category name and image are required.");
    } else {
        // Getting extension of file
        $extension = pathinfo($category_image_name, PATHINFO_EXTENSION);
        // File formats array
        $img_formats_arr = ["jpg", "jpeg", "gif", "png", "tiff", "tif"];

        // Checking file is image or not
        if (!in_array($extension, $img_formats_arr)) {
            $msg = danger_msg("Please select an image of <b>jpg</b>, <b>jpeg</b>, <b>gif</b>, <b>png</b>, <b>tiff</b> or <b>tif</b> format.");
        // Checking file size
        } elseif ($category_image_size > 50000000) {
            $msg = danger_msg("Please select image file of size less than 50MB.");
        } else {

            $for_path_datetime = date("H_i_s-Y_m_d");
            $path = "src/dynamic/categories_image/".$category_name."@".$for_path_datetime.".". $extension;
            $upload = move_uploaded_file($category_image_tmp_name, $path);

            if (!$upload) {
                $msg = danger_msg("Image could not upload. Please try again later.");
            } else {
                $insert_sql = "INSERT INTO `categories` (`category_name`, `image_path`, `status`, `added_on`) 
                VALUE ('$category_name', '$path', 'active', '$datetime')";
                $insert_res = mysqli_query($conn, $insert_sql);
            
                if ($insert_res) {
                    $msg = success_msg("<b><q>".$category_name."</b></q> Category has been added.");
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
    
    <link rel="stylesheet" href="css/categories.css">
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
                        <h2>Add Category</h2>
                    </div>
                </div>
                <div class="downer-section">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="category-name-div">
                            <label for="category-name">Enter Category Name</label>
                            <input type="text" name="category-name" id="category-name" placeholder="Enter Category Name">
                        </div>
                        <div class="category-img-div">
                            <label for="category-image">Select Category Image</label>
                            <input type="file" name="category-image" id="category-image">
                            <img id="preview_img_tag" src="src/static/default_image.PNG" alt="" srcset="">
                        </div>
                        <!-- <div class="img-div">
                        </div> -->
                        <button type="submit" name="category-submit">Add Category</button>
                    </form>
                </div>
            </div>

            <div class="section-2">
                <div class="upper-section">
                    <div class="left">
                        <h2>All Categories</h2>
                    </div>
                    <div class="right">
                        <label for="search-category">Search Category</label>
                        <input type="text" id="search-category" placeholder="Search Category">
                    </div>
                </div>
                <div class="downer-section">
                    <?php
                    
                    // Fetching all data
                    $get_data_sql = "SELECT * FROM `categories` ORDER BY `category_id` DESC";
                    $get_data_res = mysqli_query($conn, $get_data_sql);
                    $get_data_rows = mysqli_num_rows($get_data_res);

                    // Check any customer exist or not
                    if ($get_data_rows > 0) {
                        // Display Table
                        echo "<table>
                                <tr>
                                    <th>S. No. </th>
                                    <th>Categories Name</th>
                                    <th>Categories Image</th>
                                    <th>No. of Items</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Added on</th>
                                </tr>";
                        while ($data = mysqli_fetch_assoc($get_data_res)) {
                            
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
                            echo '<tr>
                                    <td>'.$category_id.'.</td>
                                    <td>'.$category_name.'</td>
                                    <td><img src="'.$image_path.'" alt="Category Pic"></td>
                                    <td>'.$get_item_rows.'</td>
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
                                            
                                            echo '<button data-category-id="'.$category_id.'" class="hide action active-action">Active</button>
                                            <button data-category-id="'.$category_id.'" class="action disable-action">Disable</button>

                                            <button data-category-id="'.$category_id.'" class="action delete-action">Delete</button>';
                                        } elseif ($status == "disabled") {
                                            
                                            echo '<button data-category-id="'.$category_id.'" class="action active-action">Active</button>
                                            <button data-category-id="'.$category_id.'" class="hide action disable-action">Disable</button>

                                            <button data-category-id="'.$category_id.'" class="action delete-action">Delete</button>';
                                        }
                                        
                                    echo '</td>
                                    <td>'.$modDate.'</td>
                                </tr>';
                        }
                        echo "</table>";
                    } else {
                        echo "No categories yet.";
                    }
                    
                    ?>
                    <!-- <table>
                        <tr>
                            <th>S. No. </th>
                            <th>Categories Name</th>
                            <th>Categories Image</th>
                            <th>No. of Items</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Added on</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Pizza</td>
                            <td><img src="../_test_img/Beef Biyani.jpg" alt="Category Pic"></td>
                            <td>2</td>
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

<script>
    // Showing preview of image
    var preview_image = document.getElementById('preview_img_tag')
    $('#category-image').change(function (e) {
        var image_type = URL.createObjectURL(e.target.files[0]);
        console.log(image_type)
        preview_image.setAttribute('src', image_type)

    })


    $(document).on('click', '.disable-action', function () {
        let category_id = $(this).data("category-id")
        
        let this_btn = $(this);
        let previous_td = $(this).parent().prev()[0].children
        
        $.ajax({
            url: 'processors/categories/active_disable_delete_category.php',
            type: 'POST',
            data: {
                action: "disable-category",
                category_id: category_id
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
        let category_id = $(this).data("category-id")
        
        let this_btn = $(this);
        let previous_td = $(this).parent().prev()[0].children
        
        $.ajax({
            url: 'processors/categories/active_disable_delete_category.php',
            type: 'POST',
            data: {
                action: "active-category",
                category_id: category_id
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
        let category_id = $(this).data("category-id")
        
        let parent_tr = $(this).parent().parent()

        $.ajax({
            url: 'processors/categories/active_disable_delete_category.php',
            type: 'POST',
            data: {
                action: "delete-category",
                category_id: category_id
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

    $("#search-category").keyup(function () {
        var value = $(this).val()

        $.ajax({
            url: 'processors/categories/search_categories.php',
            type: 'POST',
            data: {
                value: value
            },
            success: function (data) {
                console.log(data);
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