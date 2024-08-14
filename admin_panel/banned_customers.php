<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");

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
    
    <link rel="stylesheet" href="css/customers.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_sidebar.php"; ?>
    
    <div class="main-container">

        <?php include "_header.php"; ?>
        
        <div class="section">
            <div class="upper-section">
                <div class="left">
                    <h2>Banned Customers</h2>
                </div>
                <div class="right">
                    <label for="search-customer">Search Customer</label>
                    <input type="text" id="search-customer" placeholder="Search Customer">
                </div>
            </div>
            <div class="downer-section">
            <?php
                
                // Fetching Details
                $get_data_sql = "SELECT * FROM `customers` WHERE `status` = 'banned' ORDER BY `customer_id` DESC";
                $get_data_res = mysqli_query($conn, $get_data_sql);
                $get_data_rows = mysqli_num_rows($get_data_res);

                // Check any customer exist or not
                if ($get_data_rows > 0) {

                    // Display table
                    echo '<table>
                    <tr>
                        <th>S. No. </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Registered at</th>
                    </tr>';

                    // While loop for fetching data
                    while ($data = mysqli_fetch_assoc($get_data_res)) {
                        
                        // Assign variables to data fetched from database
                        $customer_id = $data['customer_id'];
                        $name = $data['name'];
                        $email = $data['email'];
                        $mobile_no = $data['mobile_no'];
                        $datetime = $data['registered_on'];

                        // Modifying date
                        $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($datetime));
                        
                        // Display data in rows
                        echo '<tr>
                                <td>'.$customer_id.'</td>
                                <td>'.$name.'</td>
                                <td>'.$email.'</td>
                                <td>'.$mobile_no.'</td>
                                <td><span class="status banned-status">Banned</span></td>
                                <td>
                                    <button data-customer-id="'.$customer_id.'" class="action unban-action">Unban</button>
                                </td>
                                <td>'.$modDate.'</td>
                            </tr>';
                    }
                    echo '</table>';
                } else {
                    echo "No banned customers yet.";
                }
                

                ?>
                <!-- <table>
                    <tr>
                        <th>S. No. </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Registered on</th>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>Muhammad Azam</td>
                        <td>azam78454@gmail.com</td>
                        <td>03333333333</td>
                        <td>
                            <span class="status active-status">Active</span>
                            <span class="status banned-status">Banned</span>
                        </td>
                        <td>03:35 pm <b>||</b> 07 Mar, 2023</td>
                    </tr>
                </table> -->
            </div>

        </div>
    </div>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>
    $(document).on('click', '.unban-action', function () {
        let customer_id = $(this).data("customer-id")

        $.ajax({
            url: 'processors/customers/ban_unban_action.php',
            type: 'POST',
            data: {
                action: "unban-customer",
                customer_id: customer_id
            },
            success: function (data) {
                if (data == 1) {
                    location.href = location.href
                } else {
                    console.log(data);
                }
            }
        })
    })

    $("#search-customer").keyup(function () {
        var value = $(this).val()

        $.ajax({
            url: 'processors/customers/search_customers.php',
            type: 'POST',
            data: {
                value: value,
                customer_type: 'banned'
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