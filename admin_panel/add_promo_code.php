<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
$datetime = date("Y-m-d H:i:s");

$msg = "";

if (isset($_POST['submit'])) {

    $promo_code = mysqli_real_escape_string($conn, $_POST['promo-code']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $minimum_amount = mysqli_real_escape_string($conn, $_POST['minimum-amount']);
    
    if (!(isset($_POST['discount-mode'])) || $promo_code == "" || $discount == "" || $minimum_amount == "") {
        $msg = danger_msg("Please fill all fields.");
    } else {
        // Check exist or not
        $get_sql = "SELECT * FROM `promo_code` WHERE `promo_code`='$promo_code'";
        $get_res = mysqli_query($conn, $get_sql);
        $get_rows = mysqli_num_rows($get_res);

        if ($get_rows == 0) {
            
            $discount_mode = mysqli_real_escape_string($conn, $_POST['discount-mode']);
                    
            $insert_sql = "INSERT INTO `promo_code` (`promo_code`, `discount`, `discount_mode`, `minimum_amount`, `status`, `added_on`) 
            VALUES ('$promo_code', '$discount', '$discount_mode', '$minimum_amount', 'active', '$datetime')";
            $insert_res = mysqli_query($conn, $insert_sql);
        
            if ($insert_res) {
                $msg = success_msg("Promo Code has been added successfully.");
            } else {
                $msg = danger_msg("Something went wrong! Please try again later.");
                
            }
        
            // echo $promo_code;
            // echo $discount;
            // echo $discount_mode;
        } else {
            $msg = danger_msg("This Promo code has been added.");
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
    
    <link rel="stylesheet" href="css/add_promo_code.css">
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
                        <h2>Add Promo Code</h2>
                    </div>
                </div>
                <div class="downer-section">
                    <form method="POST">
                        <div class="upper-form">
                            <div class="promo-code-div">
                                <label for="promo-code">Enter Promo Code</label>
                                <input type="text" name="promo-code" id="promo-code" placeholder="Enter Promo Code">
                            </div>
                            <div class="discount-div">
                                <label for="discount">Enter Discount</label>
                                <input type="number" name="discount" id="discount" placeholder="Enter Discount">
                            </div>
                            <div class="minimum-amount-div">
                                <label for="minimum-amount">Enter Minimum Amount</label>
                                <input type="number" name="minimum-amount" id="minimum-amount" placeholder="Enter Minimum Amount">
                            </div>
                        </div>
                        <div class="discount-mode-div">
                            <h3>Select Discount Mode</h3>
                            <span class="rupees-div">
                                <input type="radio" id="rupees" value="In Rupees (PKR)" name="discount-mode">
                                <label for="rupees">In Rupees (PKR)</label>
                            </span>
                            <span class="percentage-div">
                                <input type="radio" id="percentage" value="In Percentage (%)" name="discount-mode">
                                <label for="percentage">In Percentage (%)</label>
                            </span>
                        </div>
                        <button type="submit" name="submit">Add Promo Code</button>
                    </form>
                </div>
            </div>

            <div class="section-2">
                <div class="upper-section">
                    <div class="left">
                        <h2>Promo Codes</h2>
                    </div>
                    <div class="right">
                        <label for="search-promo-code">Search Promo Code</label>
                        <input type="text" id="search-promo-code" placeholder="Search...">
                    </div>
                </div>
                <div class="downer-section">
                    <?php
    
                    $get_promo_code_sql = "SELECT * FROM `promo_code` ORDER BY `id` DESC";
                    $get_promo_code_res = mysqli_query($conn, $get_promo_code_sql);
                    $get_promo_code_rows = mysqli_num_rows($get_promo_code_res);

                    if ($get_promo_code_rows > 0) {
                        echo '<table>
                                <tr>
                                    <th>S. No. </th>
                                    <th>Promo Code</th>
                                    <th>Discount</th>
                                    <th>Discount Mode</th>
                                    <th>Minimum Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Added on</th>
                                </tr>';
                        while ($promo_code_data = mysqli_fetch_assoc($get_promo_code_res)) {
                            $id = $promo_code_data['id'];
                            $promo_code = $promo_code_data['promo_code'];
                            $discount = $promo_code_data['discount'];
                            $discount_mode = $promo_code_data['discount_mode'];
                            $minimum_amount = $promo_code_data['minimum_amount'];
                            $status = $promo_code_data['status'];
                            $added_on = $promo_code_data['added_on'];

                            $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

                            echo '<tr>
                                    <td>'.$id.'.</td>
                                    <td>'.$promo_code.'</td>
                                    <td>'.$discount.'</td>
                                    <td>'.$discount_mode.'</td>
                                    <td>'.$minimum_amount.'</td>
                                    <td>';
                                        if ($status == 'active') {
                                            echo '<span class="status active-status">Active</span>
                                                <span class="status disabled-status hide">Disabled</span>';
                                        } elseif ($status == 'disabled') {
                                            echo '<span class="status active-status hide">Active</span>
                                                <span class="status disabled-status">Disabled</span>';
                                        }
                                        
                                        
                                    echo '</td>
                                    <td>';
                                        if ($status == 'active') {
                                            echo '<button data-promo-code-id="'.$id.'" class="action active-action hide">Active</button>
                                            <button data-promo-code-id="'.$id.'" class="action disable-action">Disable</button>
                                            <button data-promo-code-id="'.$id.'" class="action delete-action">Delete</button>';
                                        } elseif ($status == 'disabled') {
                                            echo '<button data-promo-code-id="'.$id.'" class="action active-action">Active</button>
                                            <button data-promo-code-id="'.$id.'" class="action disable-action hide">Disable</button>
                                            <button data-promo-code-id="'.$id.'" class="action delete-action">Delete</button>';
                                        }
                                    echo '</td>
                                    <td>'.$modDate.'</td>
                                </tr>';
                        }
                        echo '</table>';
                    } else {
                        echo "No promo code yet!";
                    }
                    


                    ?>
                    <!-- <table>
                        <tr>
                            <th>S. No. </th>
                            <th>Promo Code</th>
                            <th>Discount</th>
                            <th>Discount Mode</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Added on</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>EIDSPECIAL</td>
                            <td>200</td>
                            <td>In Rupees</td>
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

    $(document).on('click', '.active-action', function () {
        let promo_code_id = $(this).data('promo-code-id');

        let this_btn = $(this)
        let previous_td = $(this).parent().prev()[0].children
        
        $.ajax({
            url: 'processors/promo_code/active_disable_delete_promo_code.php',
            type: 'POST',
            data: {
                action: "active-promo-code",
                promo_code_id: promo_code_id
            },
            success: function (data) {
                if (data == 1) {
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
    
    $(document).on('click', '.disable-action', function () {
        let promo_code_id = $(this).data('promo-code-id');

        let this_btn = $(this)
        let previous_td = $(this).parent().prev()[0].children
        
        $.ajax({
            url: 'processors/promo_code/active_disable_delete_promo_code.php',
            type: 'POST',
            data: {
                action: "disable-promo-code",
                promo_code_id: promo_code_id
            },
            success: function (data) {
                if (data == 1) {
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
    
    $(document).on('click', '.delete-action', function () {
        let this_btn = $(this)
        let promo_code_id = $(this).data('promo-code-id');
        
        $.ajax({
            url: 'processors/promo_code/active_disable_delete_promo_code.php',
            type: 'POST',
            data: {
                action: "delete-promo-code",
                promo_code_id: promo_code_id
            },
            success: function (data) {
                if (data == 1) {
                    $(this_btn).parent().parent().remove()
                } else {
                    console.log(data);
                }
            }
        })
    })

    
    $('#search-promo-code').keyup(function () {
        let search = $(this).val()

        $.ajax({
            url: 'processors/promo_code/search_promo_code.php',
            type: 'POST',
            data: {
                search: search,
            },
            success: function (data) {
                if (data != 0) {
                    $('.section-2 .downer-section').html(data)
                } else {
                    console.log(data);
                }
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