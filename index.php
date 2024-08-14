<?php

date_default_timezone_set("Asia/Karachi");
require "_config.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home - Foodie Fizz</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Pattaya&family=Racing+Sans+One&display=swap" rel="stylesheet">

    <!-- Fontawesome Link -->
    <link rel="stylesheet" href="fontawesome_icon/css/all.min.css">

    <!-- Swiper Slider Link -->
    <link rel="stylesheet" href="swiper_slider/swiper-bundle.min.css"/>

    <!-- Local Links -->
    <link rel="shortcut icon" href="img/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/_utils.css">
    <link rel="stylesheet" href="css/_header_footer.css">
    <link rel="stylesheet" href="css/_single_item.css">
    
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

<div class="head-main-container">
    <?php include "_header.php"; ?>

    <section>
        <div class="banner">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img width="100px" src="img/home/banner_pics/1.jpg" alt="Pic"></div>
                    <div class="swiper-slide"><img width="100px" src="img/home/banner_pics/2.jpg" alt="Pic"></div>
                    <div class="swiper-slide"><img width="100px" src="img/home/banner_pics/3.jpg" alt="Pic"></div>
                    <div class="swiper-slide"><img width="100px" src="img/home/banner_pics/4.jpg" alt="Pic"></div>
                    <div class="swiper-slide"><img width="100px" src="img/home/banner_pics/5.jpg" alt="Pic"></div>
                </div>
                <div class="black-bg"></div>

                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="upper-banner">
                <h1>Foodie Fizz</h1>
                <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi similique facere asperiores reiciendis ad commodi dolores voluptate alias magnam officia!</p> -->
                <p>The place from where you can get taste like Heaven. Here you can order your favourite food and we will deliver your food at your destination for free. You can also reserve a table online.</p>
                <a href="#">Book a Table</a>
            </div>
            <div class="downer-banner">
                <?php
                
                $get_category_sql = "SELECT * FROM `categories` WHERE `status`='active' ORDER BY RAND() LIMIT 4";
                $get_category_res = mysqli_query($conn, $get_category_sql);
                $get_category_rows = mysqli_num_rows($get_category_res);

                if ($get_category_rows >= 3) {

                    while ($category_data = mysqli_fetch_assoc($get_category_res)) {
                        $category_id = $category_data['category_id'];
                        $category_name = $category_data['category_name'];
                        $image_path = $category_data['image_path'];
                        
                        echo '<div class="item item-1">
                            <a href="items.php?category_id='.$category_id.'">
                                <img src="admin_panel/'.$image_path.'" alt="Category Pic">
                                <span>'.$category_name.'</span>
                            </a>
                        </div>';
                    }
                    
                }

                
                ?>
                <!-- <div class="item item-1">
                    <a href="#">
                        <img src="img/home/banner_pics/1.jpg" alt="Pic">
                        <span>Burger</span>
                    </a>
                </div> -->
            </div>
        </div>
        <div class="sections">
            <div class="most-ordered-items">
                <h1><span class="dash"></span>Most Ordered Products</h1>
                <div class="items">

                <?php
                
                $get_item_sql = "SELECT * FROM `items` WHERE `status`='active' ORDER BY `number_of_order` DESC LIMIT 4";
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

                        echo '<div class="item">
                                <div class="img">
                                    <img class="item-img" src="admin_panel/'.$image_path.'" alt="Pic">
                                </div>
                                <div class="item-name">'.$item_name.'</div>
                                <!-- <div class="item-price">Rs. 200</div> -->
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
                
                    <!-- <div class="item item-1">
                        <div class="img">
                            <img class="item-img" src="img/home/banner_pics/2.jpg" alt="Pic">
                        </div>
                        <div class="item-name">Chicken Chicken Sandwich</div>
                        <div class="item-price">Rs. 200</div>
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
                    </div> -->
                </div>
                <a href="categories.php" class="more">See all Categories...</a>
            </div>

            <div class="food-types">
                <div class="part part-1">
                    <div class="img-div">
                        <img src="img/home/food_types/coffee-cup-white.png" alt="Pic">
                    </div>
                    <p class="head">Enjoy Eating</p>
                    <p class="para">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                </div>
                <div class="part part-2">
                    <div class="img-div">
                        <img src="img/home/food_types/fish-white.png" alt="Pic">
                    </div>
                    <p class="head">Fresh Sea Foods</p>
                    <p class="para">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                </div>
                <div class="part part-3">
                    <div class="img-div">
                        <img src="img/home/food_types/food-white.png" alt="Pic">
                    </div>
                    <p class="head">Cup of Coffees</p>
                    <p class="para">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                </div>
                <div class="part part-4">
                    <div class="img-div">
                        <img src="img/home/food_types/meat-white.png" alt="Pic">
                    </div>
                    <p class="head">Meat Eaters</p>
                    <p class="para">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                </div>
            </div>
            <!-- <div class="latest-items">
                <h1><span class="dash"></span>Latest Products</h1>
                <div class="items">
                    <div class="item item-1">
                        <div class="img">
                            <img class="item-img" src="img/home/banner_pics/2.jpg" alt="Pic">
                        </div>
                        <div class="item-name">Chicken Chicken Sandwich</div>
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
                            <button class="remove-from-cart-btn">- Remove from cart</button>
                        </div>
                    </div>
                    <div class="item item-2">
                        <div class="img">
                            <img class="item-img" src="img/home/banner_pics/2.jpg" alt="Pic">
                        </div>
                        <div class="item-name">Sandwich</div>
                        <div class="item-price">Rs. 200</div>
                        <div class="counter">
                            <button class="operation decrement">-</button>
                            <span class="number">1</span>
                            <button class="operation increment">+</button>
                        </div>
                        <div class="add-to-cart">
                            <button class="add-to-cart-btn">+ Add to cart</button>                            
                        </div>
                    </div>
                    <div class="item item-3">
                        <div class="img">
                            <img class="item-img" src="img/home/banner_pics/2.jpg" alt="Pic">
                        </div>
                        <div class="item-name">Sandwich</div>
                        <div class="item-price">Rs. 200</div>
                        <div class="counter">
                            <button class="operation decrement">-</button>
                            <span class="number">1</span>
                            <button class="operation increment">+</button>
                        </div>
                        <div class="add-to-cart">
                            <button class="add-to-cart-btn">+ Add to cart</button>                            
                        </div>
                    </div>
                    <div class="item item-4">
                        <div class="img">
                            <img class="item-img" src="img/home/banner_pics/2.jpg" alt="Pic">
                        </div>
                        <div class="item-name">Sandwich</div>
                        <div class="item-price">Rs. 200</div>
                        <div class="counter">
                            <button class="operation decrement">-</button>
                            <span class="number">1</span>
                            <button class="operation increment">+</button>
                        </div>
                        <div class="add-to-cart">
                            <button class="add-to-cart-btn">+ Add to cart</button>                            
                        </div>
                    </div>
                </div>
                <a href="#" class="more-categories">See all Categories...</a>
            </div> -->

            <div class="stories-section">
                <h1><span class="dash"></span>Latest Stories</h1>
                <div class="stories">
                    <div class="story story-1">
                        <div class="img">
                            <img src="_test_img/Beef Biyani.jpg" alt="Story Pic">
                        </div>
                        <div class="date">
                            <i class="fa-regular fa-calendar-days"></i>
                            March 12, 2023
                        </div>
                        <div class="title"><h3>New Branch Opening</h3></div>
                        <div class="para">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt aut...</div>
                        <div class="read-more">
                            <a href="#">Read More... <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="story story-2">
                        <div class="img">
                            <img src="_test_img/Beef Biyani.jpg" alt="Story Pic">
                        </div>
                        <div class="date">
                            <i class="fa-regular fa-calendar-days"></i>
                            March 12, 2023
                        </div>
                        <div class="title"><h3>New Branch Opening</h3></div>
                        <div class="para">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt aut...</div>
                        <div class="read-more">
                            <a href="#">Read More... <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="story story-3">
                        <div class="img">
                            <img src="_test_img/Beef Biyani.jpg" alt="Story Pic">
                        </div>
                        <div class="date">
                            <i class="fa-regular fa-calendar-days"></i>
                            March 12, 2023
                        </div>
                        <div class="title"><h3>New Branch Opening</h3></div>
                        <div class="para">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt aut...</div>
                        <div class="read-more">
                            <a href="#">Read More... <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="story story-4">
                        <div class="img">
                            <img src="_test_img/Beef Biyani.jpg" alt="Story Pic">
                        </div>
                        <div class="date">
                            <i class="fa-regular fa-calendar-days"></i>
                            March 12, 2023
                        </div>
                        <div class="title"><h3>New Branch Opening</h3></div>
                        <div class="para">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt aut...</div>
                        <div class="read-more">
                            <a href="#">Read More... <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <a href="#" class="more">See all Stories...</a>
            </div>

            <div id="counts-div" class="counts-div">
                <div class="count experienced-years">
                    <div class="number">80</div>
                    <p>YEARS OF EXPERIENCED</p>
                </div>
                <div class="count menus">
                    <div class="number">100</div>
                    <p>MENUS/DISHES</p>
                </div>
                <div class="count staffs">
                    <div class="number">50</div>
                    <p>STAFFS</p>
                </div>
                <div class="count customers">
                    <div class="number">15,000</div>
                    <p>HAPPY CUSTOMERS</p>
                </div>
            </div>

            <div class="cards">
                <?php
                
                $get_random_sql = "SELECT * FROM `items` ORDER BY RAND() LIMIT 2";
                $get_random_res = mysqli_query($conn, $get_random_sql);
                $get_random_rows = mysqli_num_rows($get_random_res);

                if ($get_random_rows > 0) {

                    while ($get_random_data = mysqli_fetch_assoc($get_random_res)) {
                        // Assigning variables to data 
                        $item_id = $get_random_data['item_id'];
                        $item_name = $get_random_data['item_name'];
                        $image_path = $get_random_data['image_path'];
                        $category_id = $get_random_data['category_id'];

                        echo '<div class="card card-1">
                                <div class="left-card-side">
                                    <img src="admin_panel/'.$image_path.'" alt="Item pic">
                                </div>
                                <div class="right-card-side">
                                    <h1>'.$item_name.'</h1>
                                    <p>The best quality product.</p>
                                    <button class="card-btn" data-category-id="'.$category_id.'" data-item-id="'.$item_id.'">+ Add to cart</button>
                                </div>
                            </div>';
                    }
                } else {
                    echo 'No items yet. Coming soon!';
                }
                
                
                ?>
                <!-- <div class="card card-1">
                    <div class="left-card-side">
                        <img src="_test_img/Beef Biyani.jpg" alt="">
                    </div>
                    <div class="right-card-side">
                        <h1>Sandwich</h1>
                        <p>The best quality product.</p>
                        <button class="add-to-cart-btn">+ Add to cart</button>
                    </div>
                </div> -->
            </div>
            
            <div class="services">
                <div class="service service-1">
                    <img src="img/home/services/shipped.png" alt="Pic">
                    <p class="head">Fast & Free Delivery</p>
                    <p class="para">Free delivery on all orders</p>
                </div>
                <div class="service service-2">
                    <img src="img/home/services/security-payment.png" alt="Pic">
                    <p class="head">Secure Payment</p>
                    <p class="para">Free delivery on all orders</p>
                </div>
                <div class="service service-3">
                    <img src="img/home/services/money-back.png" alt="Pic">
                    <p class="head">Money Back Guarantee</p>
                    <p class="para">Free delivery on all orders</p>
                </div>
                <div class="service service-4">
                    <img src="img/home/services/24-hours-support.png" alt="Pic">
                    <p class="head">Online Support</p>
                    <p class="para">Free delivery on all orders</p>
                </div>
            </div>
        </div>
    </section>
    
    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>

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

    $(document).on('click', ".card-btn", function () {
        let item_id = $(this).data("item-id")
        let category_id = $(this).data("category-id")

        location.href = `items.php?category_id=${category_id}#${item_id}`

    })
    
</script>

<!-- Header Footer Js -->
<script src="js/_header_footer.js"></script>

<!-- Counter JS -->
<script src="js/counter.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<!-- Swiper Slider Link -->
<script src="swiper_slider/swiper-bundle.min.js"></script>
<script src="swiper_slider/my-js.js"></script>

</html>