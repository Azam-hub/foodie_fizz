<?php

require "_config.php";
date_default_timezone_set("Asia/Karachi");
$current_datetime = date("YnjHis");

if (isset($_GET['related_to'])) {

    $related_to = $_GET['related_to'];
    
    if ($related_to != 'billing' && $related_to != 'technical' && $related_to != 'food' && 
    $related_to != 'other' && $related_to != 'closed') {
        header('location: customers_queries.php');
    }
} else {
    $related_to = 'all';
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
    
    <link rel="stylesheet" href="css/customers_queries.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_sidebar.php"; ?>
    
    <div class="main-container">

        <?php include "_header.php"; ?>
        
        <div class="section">
            <div class="upper-section">
                <div class="left">
                    <?php
                    if ($related_to == "all") {
                        echo '<h2>All Opened Queries</h2>';
                        $get_queries_sql = "SELECT * FROM `queries` WHERE `status`='opened' ORDER BY `id` DESC";

                    } else if ($related_to == "billing") {
                        echo '<h2>Billing Queries</h2>';
                        $get_queries_sql = "SELECT * FROM `queries` WHERE `related_to`='billing' ORDER BY `id` DESC";

                    } else if ($related_to == "technical") {
                        echo '<h2>Technical Queries</h2>';
                        $get_queries_sql = "SELECT * FROM `queries` WHERE `related_to`='technical' ORDER BY `id` DESC";

                    } else if ($related_to == "food") {
                        echo '<h2>Food Queries</h2>';
                        $get_queries_sql = "SELECT * FROM `queries` WHERE `related_to`='food' ORDER BY `id` DESC";

                    } else if ($related_to == "other") {
                        echo '<h2>Other Queries</h2>';
                        $get_queries_sql = "SELECT * FROM `queries` WHERE `related_to`='other' ORDER BY `id` DESC";

                    } else if ($related_to == "closed") {
                        echo '<h2>Closed Queries</h2>';
                        $get_queries_sql = "SELECT * FROM `queries` WHERE `status`='closed' ORDER BY `id` DESC";

                    }
                    ?>
                    
                    <h5>Recent Queries Upside</h5>
                </div>
                <div class="right">
                    <label for="search-query">Search Query</label>
                    <input type="text" id="search-query" placeholder="Search...">
                </div>
            </div>
            <div class="downer-section">
                <?php
                
                $get_queries_res = mysqli_query($conn, $get_queries_sql);
                $get_queries_rows = mysqli_num_rows($get_queries_res);

                if ($get_queries_rows > 0) {
                    
                    echo '<table>
                    <tr>
                        <th>S. No. </th>
                        <th>Name</th>
                        <th>Email</th>
                        '.($related_to == "all" || $related_to == "closed" ? '<th>Related to</th>' : '').'
                        <th>Subject</th>
                        <th>Query</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Added on</th>
                    </tr>';

                    while ($queries_data = mysqli_fetch_assoc($get_queries_res)) {
                        $query_id = $queries_data['id'];
                        $name = $queries_data['name'];
                        $email = $queries_data['email'];
                        $phone = $queries_data['phone'];
                        $db_related_to = $queries_data['related_to'];
                        $subject = $queries_data['subject'];
                        $message = $queries_data['message'];
                        $status = $queries_data['status'];
                        $added_on = $queries_data['added_on'];

                        $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

                        echo '<tr id="'.$query_id.'">
                            <td>'.$query_id.'.</td>
                            <td>'.$name.'</td>
                            <td>'.$email.'</td>';
                            if ($related_to == "all" || $related_to == "closed") {
                                if ($db_related_to == "billing") {
                                    echo '<td>Billing</td>';
            
                                } else if ($db_related_to == "technical") {
                                    echo '<td>Technical</td>';
            
                                } else if ($db_related_to == "food") {
                                    echo '<td>Food</td>';
            
                                } else if ($db_related_to == "other") {
                                    echo '<td>Other</td>';
                                }            
                            }
                            echo '<td>'.$subject.'</td>
                            <td class="query">'.$message.'</td>
                            <td>';
                                if ($status == 'opened') {
                                    echo '<span class="status opened-status">Opened</span>
                                    <span class="status closed-status hide">Closed</span>';
                                } else if ($status == 'closed') {
                                    echo '<span class="status closed-status">Closed</span>';
                                }
                            echo '</td>
                            <td>';
                                if ($status == 'opened') {
                                    echo '<button data-query-id="'.$query_id.'" class="action close-action">Close</button>
                                    <button data-query-id="'.$query_id.'" class="action remove-action hide">Remove</button>';
                                } else if ($status == 'closed') {
                                    echo '<button data-query-id="'.$query_id.'" class="action remove-action">Remove</button>';
                                }
                            echo '</td>
                            <td>'.$modDate.'</td>
                        </tr>';
                    }

                    echo '</table>';

                } else {
                    if ($related_to == "all") {
                        echo 'There is no queries yet.';
                    } else if ($related_to == "billing") {
                        echo 'There is no billing queries yet.';
                    } else if ($related_to == "technical") {
                        echo 'There is no technical queries yet.';
                    } else if ($related_to == "food") {
                        echo 'There is no food queries yet.';
                    } else if ($related_to == "other") {
                        echo 'There is no other queries yet.';
                    } else if ($related_to == "closed") {
                        echo 'There is no closed queries yet.';
                    }
                }
                                
                ?>
                <!-- <table>
                    <tr>
                        <th>S. No. </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Related to</th>
                        <th>Subject</th>
                        <th>Query</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Added on</th>
                    </tr>
                    
                    <tr>
                        <td>1.</td>
                        <td>Muhammad Azam</td>
                        <td>azam78454@gmail.com</td>
                        <td>Billing</td>
                        <td>Appreciation</td>
                        <td class="query">Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, et.</td>
                        <td>
                            <span class="status opened-status">Opened</span>
                            <span class="status closed-status">Closed</span>
                        </td>
                        <td>
                            <button class="action close-action">Close</button>
                            <button class="action open-action">Open</button>
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

    // $('.dot').remove()

    let current_datetime = <?php echo $current_datetime; ?>;
    localStorage.setItem('queries_last_seen', current_datetime);

    $(document).on('click', '.close-action', function () {
        let query_id = $(this).data('query-id');
        let this_btn = $(this)
        let open_status = $(this).parent().prev()[0].children[0]
        let close_status = $(this).parent().prev()[0].children[1]

        $.ajax({
            url: 'processors/customer_queries/query_closer.php',
            type: 'POST',
            data: {
                action: "close-query",
                query_id: query_id
            },
            success: function (data) {
                if (data == 1) {
                    $(this_btn).hide()
                    $(this_btn).next().show()
                    
                    $(open_status).hide()
                    $(close_status).show()
                } else {
                    console.log(data);
                }
            }
        })
    })

    $(document).on('click', '.remove-action', function () {
        let query_id = $(this).data('query-id');
        let this_btn = $(this)

        $.ajax({
            url: 'processors/customer_queries/query_closer.php',
            type: 'POST',
            data: {
                action: "remove-query",
                query_id: query_id
            },
            success: function (data) {
                if (data == 1) {
                    $(this_btn).parent().parent().hide()
                } else {
                    console.log(data);
                }
            }
        })
    })


    let parameter = (window.location.href).split('?')[1];
    var related_to;
    if (parameter) {
        related_to = (parameter.split('='))[1]
    } else {
        related_to = 'all';
    }

    $('#search-query').keyup(function () {
        let search = $(this).val()

        $.ajax({
            url: 'processors/customer_queries/search_query.php',
            type: 'POST',
            data: {
                related_to: related_to,
                search: search
            },
            success: function (data) {
                $('.downer-section').html(data)
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