<?php
          
require "_config.php";
                
                
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categories - Foodie Fizz</title>

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
    <link rel="shortcut icon" href="img/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/_utils.css">
    <link rel="stylesheet" href="css/_header_footer.css">
    
    <link rel="stylesheet" href="css/categories.css">
</head>
<body>

<div class="head-main-container">
    <?php include "_header.php"; ?>

    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Categories</h1>
            </div>
            <div class="upper-section-right">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="search-categories" placeholder="Search Food Category...">
            </div>
        </div>
        <div class="downer-section">
            <div class="categories">
                <?php
    
                $get_data_sql = "SELECT * FROM `categories` WHERE `status`='active' ORDER BY `category_id` DESC LIMIT 20";
                $get_data_res = mysqli_query($conn, $get_data_sql);
                $get_data_rows = mysqli_num_rows($get_data_res);

                if ($get_data_rows > 0) {
                    $last_category_id = "";
                    while ($data = mysqli_fetch_assoc($get_data_res)) {
                        // Assigning variables to data
                        $category_id = $data['category_id'];
                        $category_name = $data['category_name'];
                        $image_path = $data['image_path'];
                        
                        echo '<a href="items.php?category_id='.$category_id.'" class="category">
                                <img src="admin_panel/'.$image_path.'" alt="Category Pic">
                                <span>'.$category_name.'</span>
                            </a>';
                        
                        $last_category_id = $category_id;
                    }
                } else {
                    echo "No categories yet. Coming Soon!";
                }
                

                
                ?>
                <!-- <a href="#" class="category">
                    <img src="_test_img/Beef Biyani.jpg" alt="Category Pic">
                    <span>Biryani</span>
                </a>
                <a href="#" class="category">
                    <img src="_test_img/Sandwich.jpg" alt="Category Pic">
                    <span>Biryani</span>
                </a>
                <a href="#" class="category">
                    <img src="_test_img/Beef Biyani.jpg" alt="Category Pic">
                    <span>Biryani</span>
                </a>
                <a href="#" class="category">
                    <img src="_test_img/Beef Biyani.jpg" alt="Category Pic">
                    <span>Biryani</span>
                </a>
                <a href="#" class="category">
                    <img src="_test_img/Beef Biyani.jpg" alt="Category Pic">
                    <span>Biryani</span>
                </a> -->
            </div>
            <div class="load-more">
                <button data-last-category-id="<?php echo $last_category_id; ?>" class="load-more-btn">Load More..</button>
            </div>
        </div>
    </section>
    
    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>
    $("#search-categories").keyup(function () {
        let search = $(this).val()
        
        $.ajax({
            url: "processors/categories/search_categories.php",
            type: "POST",
            data: {
                search: search
            },
            success: function (data) {
                $('.msg').remove()
                if (data == 0) {
                    $(".load-more-btn").hide()
                    $(".categories").html(`There is no category like "${search}".`)

                } else {
                    
                    if (search == "") {
                        $(".load-more-btn").show()
                        var parsed_data = JSON.parse(data)
                        
                        var categories = parsed_data[0];
                        var last_category_id = parsed_data[1]
                        
                        $(".categories").html(categories)
                        $(".load-more-btn").attr("data-last-category-id", last_category_id)

                    } else {
                        $(".load-more-btn").hide()
                        var parsed_data = JSON.parse(data)
                        
                        var categories = parsed_data[0];
                        
                        $(".categories").html(categories)                        
                    }
                }
            }
        })
    })

    $(document).on('click', ".load-more-btn", function () {
        var this_btn = $(this)
        var last_category_id = $(this).attr("data-last-category-id")
        
        $.ajax({
            url: "processors/categories/load_more.php",
            type: "POST",
            data: {
                last_category_id: last_category_id
            },
            success: function (data) {
                // console.log(data);
                if (data != 0) {
                    var parsed_data = JSON.parse(data)
    
                    var categories = parsed_data[0];
                    var last_category_id = parsed_data[1]
    
                    $(".categories").append(categories)
                    $(this_btn).attr("data-last-category-id", last_category_id)
                    
                    // console.log(last_category_id);
                } else {
                    $(this_btn).hide()
                    $(".load-more").append('<span class="msg">No more categories.</span>')
                }
            }
        })
        // console.log(limit);
    })
</script>

<!-- Header Footer Js -->
<script src="js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>