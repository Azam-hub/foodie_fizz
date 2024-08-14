<?php

require "_config.php";

// Checking if user logged in or not 
session_start();
if (!(isset($_SESSION['user_logged_in'])) || $_SESSION['user_logged_in'] == false) {
    header("location: index.php");
} else {
    $customer_id = $_SESSION['customer_id'];
}

$delivery_charges = 150;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cart - Foodie Fizz</title>

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
    
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>

<div class="head-main-container"  id="head-main-container">

    <div class="black-bg"></div>
    <div class="modal">
        <i class="fa-solid fa-xmark cross-icon"></i>
        <div class="head"><h1>Select Address</h1></div>

        <?php
        
        $get_address_sql = "SELECT * FROM `address` WHERE `customer_id`='$customer_id'";
        $get_address_res = mysqli_query($conn, $get_address_sql);
        $get_address_rows = mysqli_num_rows($get_address_res);

        if ($get_address_rows > 0) {

            while ($address_data = mysqli_fetch_assoc($get_address_res)) {
                $address_id = $address_data['id'];
                $address = $address_data['address'];

                echo '<div data-address-id="'.$address_id.'" class="select-address">
                        '.$address.'
                    </div>';
            }
        } else {
            echo 'You did not add address. <a href="my_addresses.php">Add Here</a>';
        }

        ?>
        
        <!-- <div class="select-address">House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.</div> -->
    </div>

    <?php include "_header.php" ?>    

    <div class="js-msg"></div>
    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Cart</h1>
            </div>
        </div>
        <div class="downer-section">

        <?php
                            
        $get_cart_items_sql = "SELECT * FROM `cart` WHERE `customer_id`='$customer_id'";
        $get_cart_items_res = mysqli_query($conn, $get_cart_items_sql);
        $get_cart_items_rows = mysqli_num_rows($get_cart_items_res);

        if ($get_cart_items_rows > 0) {
        
        ?>
            <div class="container">
                <div class="orders-section">
                    <div class="top">
                        <h2>Your Orders</h2>
                        <p>You have <?php echo $get_cart_items_rows; ?> order in your cart.</p>
                    </div>
                    <div class="bottom">
                        <div class="table">
                            <div class="order-line order-head">
                                <span class="first-column">S.No.</span>
                                <span class="second-column">Item</span>
                                <span class="third-column">Price</span>
                                <span class="fourth-column">Quantity</span>
                                <span class="fifth-column">Total</span>
                                <span class="sixth-column"><i class="fa-regular fa-trash-can delete-all-item-btn"></i></span>
                            </div>

                            <?php
                            $i = 0;
                            $grand_total = 0;
                            while ($cart_data = mysqli_fetch_assoc($get_cart_items_res)) {
                                $i = $i + 1;
                                // Get cart rows
                                $cart_id = $cart_data['id'];
                                $item_id = $cart_data['item_id'];
                                $quantity = $cart_data['quantity'];
                
                                // Get Item info
                                $get_item_sql = "SELECT * FROM `items` WHERE `item_id`='$item_id'";
                                $get_item_res = mysqli_query($conn, $get_item_sql);
                                $item_data = mysqli_fetch_assoc($get_item_res);

                                // assigning variables to fetched data
                                $item_name = $item_data['item_name'];
                                $item_price = $item_data['item_price'];
                                $image_path = $item_data['image_path'];

                                $row_total = ($item_price)*($quantity);
                
                                echo '<div class="order-line main-order">
                                        <span class="first-column">'.$i.'. </span>
                                        <span class="second-column">
                                            <img src="admin_panel/'.$image_path.'" alt="Item Pic">
                                            <p>'.$item_name.'</p>
                                        </span>
                                        <span class="third-column">Rs. '.$item_price.'</span>
                                        <span class="fourth-column">'.$quantity.'</span>
                                        <span class="fifth-column">Rs. '.$row_total.'</span>
                                        <span class="sixth-column"><i data-cart-id="'.$cart_id.'" class="fa-regular fa-trash-can delete-item-btn"></i></span>
                                    </div>';
                
                                $grand_total = $grand_total + $row_total;
                            }

                            ?>

                            <div class="order-line grand-total">
                                <span class="first-column">Total :</span>
                                <span class="second-column"></span>
                                <span class="third-column"></span>
                                <span class="fourth-column"></span>
                                <span class="fifth-column">Rs. <?php echo $grand_total; ?></span>
                                <span class="sixth-column"></span>
                            </div>
                        </div>
                        

                        <!-- <div class="table">
                            <div class="order-line order-head">
                                <span class="first-column">S.No.</span>
                                <span class="second-column">Item</span>
                                <span class="third-column">Price</span>
                                <span class="fourth-column">Quantity</span>
                                <span class="fifth-column">Total</span>
                                <span class="sixth-column">Added On</span>
                                <span class="seventh-column"></span>
                            </div>
                            <div class="order-line main-order">
                                <span class="first-column">1. </span>
                                <span class="second-column">
                                    <img src="_test_img/Beef Biyani.jpg" alt="Pic">
                                    <p>Beef Biryani</p>
                                </span>
                                <span class="third-column">Rs. 400</span>
                                <span class="fourth-column">2</span>
                                <span class="fifth-column">Rs. 800</span>
                                <span class="sixth-column">03:35 pm <br> 07 Mar, 2023</span>
                                <span class="seventh-column"><i class="fa-regular fa-trash-can"></i></span>
                            </div>
                            <div class="order-line grand-total">
                                <span class="first-column">Total :</span>
                                <span class="second-column"></span>
                                <span class="third-column"></span>
                                <span class="fourth-column"></span>
                                <span class="fifth-column">Rs. 1600</span>
                                <span class="sixth-column"></span>
                                <span class="seventh-column"></span>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="payment-methods-section">
                    <div class="left">
                        <div class="head">
                            <h1>Payment Methods</h1>
                        </div>
                        <div class="selection">
                            <div class="cod-payment-div">
                                <input type="radio" name="payment-methods" class="payment-radios" id="cod-payment">
                                <label for="cod-payment" class="custom-radio-label"></label>
                                <label for="cod-payment" class="txt-label">Cash on Delivery</label>
                            </div>
                            <div class="card-payment-div">
                                <input type="radio" name="payment-methods" class="payment-radios" id="card-payment" checked>
                                <label for="card-payment" class="custom-radio-label"></label>
                                <label for="card-payment" class="txt-label">Card Payment</label>
                            </div>
                        </div>
                        <div class="card-details">
                            <h2>Card Details</h2>
                            <div class="card-type">
                                <h3>Card Type</h3>
                                <i class="fa-brands fa-cc-paypal"></i>
                                <i class="fa-brands fa-cc-amex"></i>
                                <i class="fa-brands fa-cc-mastercard"></i>
                                <i class="fa-brands fa-cc-visa"></i>
                            </div>
                            <div class="form">
                                <div class="name">
                                    <input class="card-details-input" type="text" id="name">
                                    <span>Cardholder's Name</span>
                                </div>
                                <div class="number">
                                    <input class="card-details-input" type="text" id="number">
                                    <span>Card Number</span>
                                </div>
                                <div class="exp-cvv">
                                    <div class="exp">
                                        <input class="card-details-input" type="text" id="exp">
                                        <span>Expiration</span>
                                    </div>
                                    <div class="cvv">
                                        <input class="card-details-input" type="text" id="cvv">
                                        <span>Cvv</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="middle">
                        <div class="address">
                            <h1>Address</h1>
                            <button class="select-address-btn">Select Address</button>
                            <div class="selected-address hide"></div>
                        </div>
                        <?php
                        
                        if (!isset($_SESSION['promo_code_id'])) {

                            echo '<div class="promo-code">
                                <h1>Promo Code (if any)</h1>
                                <input type="text" id="promo-code" placeholder="Enter promo code">
                                <button class="promo-code-btn" id="promo-code-btn">Apply</button>
                            </div>';
                        }

                        ?>
                    </div>
                    <div class="right">
                        <div class="prices-div">
                            <h1>Total Amount</h1>
                            <div class="subtotal-div">
                                <span>Subtotal</span>
                                <span>Rs. <?php echo $grand_total; ?></span>
                            </div>
                            <div class="delivery-charges-div">
                                <span>Delivery Charges</span>
                                <span>Rs. <?php echo $delivery_charges; ?></span>
                            </div>
                            <div class="total-div">
                                <span>Total(Incl. taxes)</span>
                                <span>Rs. <?php echo $to_pay_amount = $grand_total + $delivery_charges; ?></span>
                            </div>
                        </div>
                        <div class="checkout-div">
                            <div class="checkout-btn" id="checkout-btn">

                                <?php
                                if (isset($_SESSION['promo_code_id'])) {

                                    $promo_code_id = $_SESSION['promo_code_id'];
                                    $get_sql = "SELECT * FROM `promo_code` WHERE `id`='$promo_code_id' AND `status`='active'";
                                    $get_res = mysqli_query($conn, $get_sql);
                                    $get_rows = mysqli_num_rows($get_res);

                                    if ($get_rows == 1) {
                                        
                                        // get promo code data 
                                        $data = mysqli_fetch_assoc($get_res);
                                        $discount = $data['discount'];
                                        $discount_mode = $data['discount_mode'];
                                        $minimum_amount = $data['minimum_amount'];

                                        if ($to_pay_amount >= $minimum_amount) {
                                            if ($discount_mode == 'In Rupees (PKR)') {
                            
                                                $to_pay_amount = $to_pay_amount - $discount;
                                    
                                            } elseif ($discount_mode == 'In Percentage (%)') {
                                    
                                                $discount_in_rupees = ($discount / 100) * $to_pay_amount;
                                    
                                                $to_pay_amount = $to_pay_amount - round($discount_in_rupees);
                                                
                                            }
                                            echo '<span class="checkout-price">Rs. '.$to_pay_amount.'</span>';
                                            
                                        } else {
                                            $_SESSION['promo_code_id'] = null;
                                            echo '<span class="checkout-price">Rs. '.$to_pay_amount.'</span>';
                                            // header("location: cart.php");
                                        }

                                    } else {
                                        $_SESSION['promo_code_id'] = null;
                                        echo '<span class="checkout-price">Rs. '.$to_pay_amount.'</span>';
                                        // header("location: cart.php");
                                    }
                                    
                                    
                                } else {
                                    echo '<span class="checkout-price">Rs. '.$to_pay_amount.'</span>';
                                }
                                
                                
                                ?>
                                <!-- <img src="img/loading.gif" class="loading-gif" alt="Loading GIF"> -->
                                <span class="checkout-text">
                                    <img src="img/loading.gif" class="loading-gif" alt="Loading GIF">
                                    Checkout<i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo 'There is no item in your cart.';
        }
        ?>
        </div>
    </section>
    
    <?php include "_footer.php" ?>
    
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>
    $(".card-details-input").change(function(){
        if ($(this).val() != "") {
            $(this).next().addClass('filled-input')
        } else {
            $(this).next().removeClass('filled-input')
            
        }
    })
    $('.payment-radios').change(function () {
        if ($("#cod-payment").is(":checked")) {
            $('.card-details').slideUp(600)
        } else {
            $('.card-details').slideDown(600)
        }
    })

    // Modal
    $(".cross-icon, .black-bg").click(function () {
        $('.black-bg').hide()
        $(".modal").hide()
    })
    $('.select-address-btn').click(function () {
        $('.black-bg').show()
        $(".modal").show()
    })
    // Address handler
    $(document).on('click', '.select-address', function () {
        $('.black-bg').hide()
        $('.modal').hide()
        
        var address_id = $(this).data('address-id')
        var address_txt = $(this).text()

        $('.selected-address').show()
        $('.selected-address').text(address_txt)
        $('.selected-address').attr('data-selected-address-id', address_id)
    })

    // Ajax Calls

    // Delete item from cart
    $(document).on('click', ".delete-item-btn", function () {
        var cart_id = $(this).data("cart-id")
        var this_btn = $(this)

        $.ajax({
            url: "processors/cart/remove_item.php",
            type: "POST",
            data: {
                action: 'delete-specific-item',
                cart_id: cart_id
            },
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $(this_btn).parent().parent().fadeOut(200)
                    setTimeout(() => {
                        location.reload()
                    }, 200);
                } else {
                    console.log(data);
                }
            }
        })

    })
    $(document).on('click', ".delete-all-item-btn", function () {

        $.ajax({
            url: "processors/cart/remove_item.php",
            type: "POST",
            data: {
                action: 'delete-all-items'
            },
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $('.main-order').fadeOut(200)
                    setTimeout(() => {
                        location.reload()
                    }, 200);
                } else {
                    console.log(data);
                }
            }
        })

    })

    // Promo Code apply
    $("#promo-code-btn").click(function () {
        let promo_code = $('#promo-code').val()

        $.ajax({
            url: "processors/cart/apply_promo_code.php",
            type: "POST",
            data: {
                promo_code: promo_code
            },
            success: function (data) {
                
                if (data == 0) {
                    let html = `<div class="msg danger-msg">
                                    <div class="left">
                                        <ion-icon class="icon md hydrated" name="alert-circle-outline" role="img" aria-label="alert circle outline"></ion-icon>
                                    </div>
                                    <div class="right">
                                        <p>Invalid promo code.</p>
                                    </div>
                                </div>`;
                    $(".js-msg").html(html)
                    location.hash = 'head-main-container'

                    setTimeout(() => {
                        if(typeof window.history.pushState == 'function') {
                            window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
                        }
                    }, 500);
                } else {

                    $('.checkout-price').html(`Rs. ${data}`)
                    $('.promo-code').remove()
                    // console.log(data);
                }
            }
        })
    })

    // Checkout
    $("#checkout-btn").click(function () {

        if (!($('.selected-address').attr('data-selected-address-id'))) {
            
            let html = `<div class="msg danger-msg">
                            <div class="left">
                                <ion-icon class="icon md hydrated" name="alert-circle-outline" role="img" aria-label="alert circle outline"></ion-icon>
                            </div>
                            <div class="right">
                                <p>Please select an address.</p>
                            </div>
            </div>`;
            
            $(".js-msg").html(html)
            location.hash = 'head-main-container'

            setTimeout(() => {
                if(typeof window.history.pushState == 'function') {
                    window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
                }
            }, 500);
        } else {
            
            if (!($("#cod-payment").prop("checked"))) {
                
                let html = `<div class="msg danger-msg">
                                <div class="left">
                                    <ion-icon class="icon md hydrated" name="alert-circle-outline" role="img" aria-label="alert circle outline"></ion-icon>
                                </div>
                                <div class="right">
                                    <p>Currently card payment is not available.</p>
                                </div>
                </div>`;
                
                $(".js-msg").html(html)
                location.hash = 'head-main-container'

                setTimeout(() => {
                    if(typeof window.history.pushState == 'function') {
                        window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
                    }
                }, 500);
            } else {

                let address_id = parseInt($('.selected-address').attr('data-selected-address-id'))
                $('.loading-gif').show()

                $.ajax({
                    url: 'processors/cart/place_order.php',
                    type: 'POST',
                    data: {
                        action: "checkout",
                        address_id: address_id
                    },
                    success: function (data) {
                        if (data == 1) {
                            // location.reload()
                            $('.container').remove()
                            $('.number-of-ordered-items').remove()
                            let html = `<div class="msg success-msg">
                                            <div class="left">
                                                <ion-icon class="icon md hydrated" name="checkmark-circle-outline" role="img" aria-label="checkmark circle outline"></ion-icon>
                                            </div>
                                            <div class="right">
                                                <p>Your order has been placed successfully. Please wait at least 45 minutes. We will contact you through phone number.</p>
                                            </div>
                            </div>`
                            $('section .downer-section').html(html)
                            $('.js-msg').html('')

                            location.hash = 'head-main-container'

                            setTimeout(() => {
                                if(typeof window.history.pushState == 'function') {
                                    window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
                                }
                            }, 500);

                        } else {
                            console.log(data);
                            
                            let html = `<div class="msg danger-msg">
                                            <div class="left">
                                                <ion-icon class="icon md hydrated" name="alert-circle-outline" role="img" aria-label="alert circle outline"></ion-icon>
                                            </div>
                                            <div class="right">
                                                <p>Something went wrong! Try again later or contact us <a href="contact_us.php">here</a>.</p>
                                            </div>
                            </div>`
                            
                            $('.js-msg').html(html)

                            location.hash = 'head-main-container'

                            setTimeout(() => {
                                if(typeof window.history.pushState == 'function') {
                                    window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
                                }
                            }, 500);
                        }
                    }
                })
            }
        }
    })

</script>

<!-- Header Footer Js -->
<script src="js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>