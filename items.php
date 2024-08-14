<?php

require "_config.php";

if (isset($_GET['category_id'])) {
    $url_category_id = $_GET['category_id'];
} else {
    header("location: categories.php");
}

$get_category_sql = "SELECT * FROM `categories` WHERE (`category_id`='$url_category_id')";
$get_category_res = mysqli_query($conn, $get_category_sql);
$category_data = mysqli_fetch_assoc($get_category_res);
$category_name = $category_data['category_name'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Items - Foodie Fizz</title>

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
    <link rel="stylesheet" href="css/_single_item.css">
    
    <link rel="stylesheet" href="css/items.css">
</head>
<body>

<div class="head-main-container">
    <?php include "_header.php"; ?>

    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Items of <b><q><?php echo $category_name; ?></q></b></h1>
            </div>
            <div class="upper-section-right">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="search-item" placeholder="Search Food Item...">
            </div>
        </div>
        <div class="downer-section">
            <div class="items bordered-items">
                <?php
                
                $get_item_sql = "SELECT * FROM `items` WHERE (`category_id`='$url_category_id') AND (`status`='active') ORDER BY `item_id` DESC";
                $get_item_res = mysqli_query($conn, $get_item_sql);
                $get_item_rows = mysqli_num_rows($get_item_res);

                if ($get_item_rows > 0) {

                    while ($data = mysqli_fetch_assoc($get_item_res)) {
                        // Assigning variables to data 
                        $item_id = $data['item_id'];
                        $item_name = $data['item_name'];
                        $item_price = $data['item_price'];
                        $cutted_item_price = $data['cutted_item_price'];
                        $image_path = $data['image_path'];                        

                        echo '<div class="item" id="'.$item_id.'">
                                <div class="img">
                                    <img src="admin_panel/'.$image_path.'" alt="Item Pic">
                                </div>
                                <div class="item-name">'.$item_name.'</div>
                                <div class="item-price">';
                                    if ($cutted_item_price == 0) {
                                        echo 'Rs. '.$item_price;
                                    } else {
                                        echo '<div class="price before-cutted-price">Rs. '.$item_price.'</div>
                                            <div class="cutted-price">Rs. '.$cutted_item_price.'</div>';
                                    }
                                    
                                    
                                echo '</div>
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
                } else {
                    echo 'No items yet. Coming Soon!';
                }
                
                
                ?>
                <!-- <div class="item">
                    <div class="img">
                        <img src="_test_img/Sandwich.jpg" alt="Item Pic">
                    </div>
                    <div class="item-name">Zinger Burger</div>
                    <div class="item-price">
                        <div class="price before-cutted-price">Rs. 200</div>
                        <div class="cutted-price">Rs. 400</div>
                    </div>
                    <div class="counter">
                        <button class="operation decrement">-</button>
                        <span class="number">1</span>
                        <button class="operation increment">+</button>
                    </div>
                    <div class="add-to-cart">
                        <button class="add-to-cart-btn">+ Add to cart</button>
                        <button class="remove-from-cart-btn">- Remove from cart</button>
                    </div>
                </div>
                <div class="item">
                    <div class="img">
                        <img src="_test_img/Sandwich.jpg" alt="Item Pic">
                    </div>
                    <div class="item-name">Zinger Burger</div>
                    <div class="item-price">Rs. 220</div>
                    <div class="counter">
                        <button class="operation decrement">-</button>
                        <span class="number">1</span>
                        <button class="operation increment">+</button>
                    </div>
                    <div class="add-to-cart">
                        <button class="add-to-cart-btn">+ Add to cart</button>
                    </div>
                </div> -->
            </div>
            <!-- <div class="load-more">
                <button class="load-more-btn">Load More..</button>
            </div> -->
        </div>
    </section>
    
    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>
    $("#search-item").keyup(function () {
        var search = $(this).val()

        $.ajax({
            url: "processors/items/search_items.php",
            type: "POST",
            data: {
                search: search,
                category_id: <?php echo $url_category_id; ?>
            },
            success: function (data) {
                // console.log(data);
                $('.items').html(data)
            }
        })
    })

    $(document).on('click', ".add-to-cart-btn", function () {
        var quantity = $(this).parent().prev()[0].children[1].innerHTML
        var item_id = $(this).data("item-id")
        var this_btn = $(this)

        $.ajax({
            url: "processors/items/items_in_cart.php",
            type: "POST",
            data: {
                action: "add-item",
                quantity: quantity,
                item_id: item_id
            },
            success: function (data) {
                console.log(data);
                if (data == 0) {
                    location.href = "account/login.php?first_login";
                } else if (data == 1) {
                    $(this_btn).hide()
                    $(this_btn).next().show()
                    $(this_btn).parent().prev().hide()

                    if ($('.number-of-ordered-items').length){

                        let old_number = parseInt($('.number-of-ordered-items').text())
                        $('.number-of-ordered-items').text(old_number + 1)
                    } else {
                        $('.cart-link').prepend('<span class="number-of-ordered-items">1</span>')
                    }
                } else {
                    console.log(data);
                }
            }
        })

    })

    $(document).on('click', ".remove-from-cart-btn", function () {
        var item_id = $(this).data("item-id")
        var this_btn = $(this)

        $.ajax({
            url: "processors/items/items_in_cart.php",
            type: "POST",
            data: {
                action: "remove-item",
                item_id: item_id
            },
            success: function (data) {
                console.log(data);
                if (data == 0) {
                    location.href = "account/login.php?first_login";
                } else if (data == 1) {
                    $(this_btn).hide()
                    $(this_btn).prev().show()
                    $(this_btn).parent().prev()[0].children[1].innerHTML = 1
                    $(this_btn).parent().prev().show()
                } else {
                    console.log(data);
                }
            }
        })

    })
</script>

<!-- Counter JS -->
<script src="js/counter.js"></script>

<!-- Header Footer JS -->
<script src="js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>