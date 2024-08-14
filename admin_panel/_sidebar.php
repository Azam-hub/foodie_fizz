<?php

// session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true && 
(isset($_SESSION['general_logged_in']) || isset($_SESSION['supervisor_logged_in']))) {
    relax();
} else {
    header("location: login.php");
}

?>


<div class="sidebar">
    <a href="index.php" class="top">
        <img src="src/static/logo/white_logo.png" alt="Pic">
        <h3>Admin Panel</h3>
    </a>
    <div class="down">
        
        <div class="section orders-section" id="orders">
            <h3><i class="fa-solid fa-chevron-right"></i>Orders <div class="dot"></div></h3>
            <ul>
                <li><a href="orders.php">Orders <div class="dot dot-text">1</div></a></li>
                <li><a href="delivered_orders.php">Delivered Orders</a></li>
                <!-- <li><a href="#">Removed Orders</a></li> -->
            </ul>
        </div>
        <div class="section reservations-section" id="table-reservations">
            <h3><i class="fa-solid fa-chevron-right"></i>Table Reservations <div class="dot"></div></h3>
            <ul>
                <li><a href="table_booking.php">All Reservations <div class="dot dot-text">1</div></a></li>
                <li><a href="table_booking.php?type=confirmed">Confirmed Reservations</a></li>
                <li><a href="table_booking.php?type=removed">Removed Reservations</a></li>
            </ul>
        </div>

        <?php
        if (isset($_SESSION['supervisor_logged_in']) && $_SESSION['supervisor_logged_in'] == true) {
            ?>
        

        <div class="section" id="categories-and-items">
            <h3><i class="fa-solid fa-chevron-right"></i>Categories and Items</h3>
            <ul>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="items.php">Items</a></li>
            </ul>
        </div>
        <div class="section" id="promo-code">
            <h3><i class="fa-solid fa-chevron-right"></i>Promo Code</h3>
            <ul>
                <li><a href="add_promo_code.php">Add Promo Code</a></li>
            </ul>
        </div>        
        <div class="section queries queries-section" id="queries">
            <h3><i class="fa-solid fa-chevron-right"></i>Queries <div class="dot"></div></h3>
            <ul>
                <li><a href="customers_queries.php">All Queries <div class="dot dot-text">1</div></a></li>
                <li><a href="customers_queries.php?related_to=billing">Billing Queries</a></li>
                <li><a href="customers_queries.php?related_to=technical">Technical Queries</a></li>
                <li><a href="customers_queries.php?related_to=food">Food Queries</a></li>
                <li><a href="customers_queries.php?related_to=other">Other Queries</a></li>
                <li><a href="customers_queries.php?related_to=closed"><b>Closed Queries</b></a></li>
            </ul>
        </div>
        <div class="section" id="stories">
            <h3><i class="fa-solid fa-chevron-right"></i>Stories</h3>
            <ul>
                <li><a href="#">Add Story</a></li>
            </ul>
        </div>
        <div class="section" id="customers">
            <h3><i class="fa-solid fa-chevron-right"></i>Customers</h3>
            <ul>
                <li><a href="customers.php">Customers</a></li>
                <li><a href="banned_customers.php">Banned Customers</a></li>
            </ul>
        </div>

        <?php
        }
        ?>
    </div>
</div>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>

    function check_new_records(orders_last_seen, queries_last_seen, reservation_last_seen) {
        $.ajax({
            url: 'processors/home/check_new_records.php',
            type: 'POST',
            data: {
                orders_last_seen: orders_last_seen,
                queries_last_seen: queries_last_seen,
                reservation_last_seen: reservation_last_seen
            },
            success: function (data) {
                data = JSON.parse(data)

                let orders_data = data[0];
                let queries_data = data[1];
                let reservations_data = data[2];
                let unseen_orders = data[3];
                let unseen_queries = data[4];
                let unseen_reservations = data[5];

                if (unseen_orders > 0) {
                    $('.orders-section h3 .dot').show()
                    $('.orders-section ul .dot-text').text(unseen_orders)
                    $('.orders-section ul .dot-text').css({
                        display: 'flex'
                    })
                } else {
                    $('.orders-section .dot').hide()
                }

                if (unseen_queries > 0) {
                    $('.queries-section h3 .dot').show()
                    $('.queries-section ul .dot-text').text(unseen_queries)
                    $('.queries-section ul .dot-text').css({
                        display: 'flex'
                    })
                } else {
                    $('.queries-section .dot').hide()
                }

                if (unseen_reservations > 0) {
                    $('.reservations-section h3 .dot').show()
                    $('.reservations-section ul .dot-text').text(unseen_reservations)
                    $('.reservations-section ul .dot-text').css({
                        display: 'flex'
                    })
                } else {
                    $('.reservations-section .dot').hide()
                }

                if (orders_data != "") {
                    let order_html = `<div class="table">
                    <h3>New Orders</h3>
                        <table>
                            <tr>
                                <th>Order ID</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            ${orders_data}
                        </table>
                    </div>`
                    $('.orders-table').html(order_html)
                }
                if (queries_data != "") {
                    let query_html = `<div class="table">
                    <h3>New Queries</h3>
                        <table>
                            <tr>
                                <th>Query ID</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            ${queries_data}
                        </table>
                    </div>`
                    $('.query-table').html(query_html)
                }
                if (reservations_data != "") {
                    let reservation_html = `<div class="table">
                    <h3>New Reservations</h3>
                        <table>
                            <tr>
                                <th>Reservation ID</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            ${reservations_data}
                        </table>
                    </div>`
                    $('.reservation-table').html(reservation_html)
                }
            }
        })
    }


    let sidebar_orders_last_seen = localStorage.getItem('orders_last_seen')
    let sidebar_queries_last_seen = localStorage.getItem('queries_last_seen')
    let sidebar_reservation_last_seen = localStorage.getItem('reservation_last_seen')
    check_new_records(sidebar_orders_last_seen, sidebar_queries_last_seen, sidebar_reservation_last_seen)

    setInterval(() => {

        let sidebar_orders_last_seen = localStorage.getItem('orders_last_seen')
        let sidebar_queries_last_seen = localStorage.getItem('queries_last_seen')
        let sidebar_reservation_last_seen = localStorage.getItem('reservation_last_seen')
        check_new_records(sidebar_orders_last_seen, sidebar_queries_last_seen, sidebar_reservation_last_seen)
    }, 2000);
</script>