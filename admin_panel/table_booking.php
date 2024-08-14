<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
$current_datetime = date("YnjHis");

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    if ($type != 'confirmed' && $type != 'removed') {
        header('location: table_booking.php');
    }
} else {
    $type = 'all';
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
    
    <link rel="stylesheet" href="css/table_booking.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_sidebar.php"; ?>

    <div class="main-container">

        <?php include "_header.php"; ?>

        <div class="section">
            <div class="upper-section">
                <div class="left">
                    <h2>Table Booking</h2>
                </div>
                <div class="right">
                    <label for="search-reservation">Search Boooking</label>
                    <input type="text" id="search-reservation" placeholder="Search...">
                </div>
            </div>
            <div class="downer-section">
                
                <?php
                
                if ($type == 'all') {
                    $get_sql = "SELECT * FROM `table_booking` ORDER BY `id` DESC";
                } elseif ($type == 'confirmed') {
                    $get_sql = "SELECT * FROM `table_booking` WHERE `status`='confirmed' ORDER BY `id` DESC";
                } elseif ($type == 'removed') {
                    $get_sql = "SELECT * FROM `table_booking` WHERE `status`='removed' ORDER BY `id` DESC";
                }

                $get_res = mysqli_query($conn, $get_sql);
                $get_rows = mysqli_num_rows($get_res);

                if ($get_rows > 0) {
                    echo '<table>
                    <tr>
                        <th>S. No. </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Person</th>
                        <th>Reserved for</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Reserved at</th>
                    </tr>';
                    while ($data = mysqli_fetch_assoc($get_res)) {
                        $id = $data['id'];
                        $name = $data['name'];
                        $email = $data['email'];
                        $phone = $data['phone'];
                        $person = $data['person'];
                        $reserved_for = $data['reserved_for'];
                        $status = $data['status'];
                        $added_on = $data['added_on'];

                        $mod_reserved_for_datetime =  date ('h:i a <b>||</b> d M, Y', strtotime($reserved_for));
                        $mod_real_datetime =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

                        echo '<tr id="'.$id.'">
                            <td>'.$id.'.</td>
                            <td>'.$name.'</td>
                            <td>'.$email.'</td>
                            <td>'.$phone.'</td>
                            <td>'.$person.'</td>
                            <td>'.$mod_reserved_for_datetime.'</td>
                            <td>';
                                if ($status == 'pending') {
                                    echo '
                                    <span class="status pending-status">Pending</span>
                                    <span class="status confirmed-status hide">Confirmed</span>
                                    <span class="status removed-status hide">Removed</span>';
                                } elseif ($status == 'confirmed') {
                                    echo '
                                    <span class="status pending-status hide">Pending</span>
                                    <span class="status confirmed-status">Confirmed</span>
                                    <span class="status removed-status hide">Removed</span>';
                                } elseif ($status == 'removed') {
                                    echo '
                                    <span class="status pending-status hide">Pending</span>
                                    <span class="status confirmed-status hide">Confirmed</span>
                                    <span class="status removed-status">Removed</span>';
                                }
                                
                            echo '</td>
                            <td>';
                                if ($status == 'pending') {
                                    echo '
                                    <button data-reservation-id="'.$id.'" class="action confirm-action">Confirm</button>
                                    <button data-reservation-id="'.$id.'" class="action remove-action">Remove</button>
                                    <button data-reservation-id="'.$id.'" class="action delete-action hide">Delete</button>';
                                } elseif ($status == 'confirmed') {
                                    echo '
                                    <button data-reservation-id="'.$id.'" class="action delete-action">Delete</button>';
                                } elseif ($status == 'removed') {
                                    echo '
                                    <button data-reservation-id="'.$id.'" class="action delete-action">Delete</button>';
                                }
                                
                            echo '</td>
                            <td>'.$mod_real_datetime.'</td>
                        </tr>';
                    }
                    echo '</table>';
                } else {
                    echo "No table booking yet.";
                }
            
                ?>
                    <!-- <tr>
                        <td>1.</td>
                        <td>Muhammad Azam</td>
                        <td>azam78454@gmail.com</td>
                        <td>03333333333</td>
                        <td>4+</td>
                        <td>03:35 pm <b>||</b> 07 Mar, 2023</td>
                        <td>
                            <span class="status confirmed-status">Confirmed</span>
                            <span class="status pending-status">Pending</span>
                        </td>
                        <td>
                            <button class="action deliver-action">Confirm</button>
                            <button class="action remove-action">Remove</button>
                        </td>
                        <td>03:35 pm <b>||</b> 07 Mar, 2023</td>
                    </tr> -->
                
            </div>

        </div>
    </div>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>

    // $('.dot').remove()

    let current_datetime = <?php echo $current_datetime; ?>;
    localStorage.setItem('reservation_last_seen', current_datetime);

    $(document).on('click', '.confirm-action', function () {
        let reservation_id = $(this).data('reservation-id')
        
        let this_btn = $(this)
        let pending_status = $(this).parent().prev()[0].children[0]
        let confirmed_status = $(this).parent().prev()[0].children[1]

        $.ajax({
            url: 'processors/table_booking/confirm_remove_delete.php',
            type: 'POST',
            data: {
                action: "confirm",
                reservation_id: reservation_id
            },
            success: function (data) {
                if (data == 1) {
                    $(pending_status).hide()
                    $(confirmed_status).show()

                    $(this_btn).hide()
                    $(this_btn).next().hide()
                    $(this_btn).next().next().show()
                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.remove-action', function () {
        let reservation_id = $(this).data('reservation-id')
        
        let this_btn = $(this)
        let pending_status = $(this).parent().prev()[0].children[0]
        let removed_status = $(this).parent().prev()[0].children[2]

        $.ajax({
            url: 'processors/table_booking/confirm_remove_delete.php',
            type: 'POST',
            data: {
                action: "remove",
                reservation_id: reservation_id
            },
            success: function (data) {
                if (data == 1) {
                    $(pending_status).hide()
                    $(removed_status).show()

                    $(this_btn).prev().hide()
                    $(this_btn).hide()
                    $(this_btn).next().show()
                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.delete-action', function () {
        let reservation_id = $(this).data('reservation-id')
        let this_btn = $(this)

        $.ajax({
            url: 'processors/table_booking/confirm_remove_delete.php',
            type: 'POST',
            data: {
                action: "delete",
                reservation_id: reservation_id
            },
            success: function (data) {
                if (data == 1) {
                    $(this_btn).parent().parent().fadeOut()
                } else {
                    console.log(data);
                }
            }
        })
    })

    
    let parameter = (window.location.href).split('?')[1];
    var type;
    if (parameter) {
        type = (parameter.split('='))[1]
    } else {
        type = 'all';
    }

    $('#search-reservation').keyup(function () {
        let search = $(this).val()

        $.ajax({
            url: 'processors/table_booking/search_reservation.php',
            type: 'POST',
            data: {
                type: type,
                search: search
            },
            success: function (data) {
                if (data == 0) {
                    console.log(data);
                } else {
                    $('.downer-section').html(data)   
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