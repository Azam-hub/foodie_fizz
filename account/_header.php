<?php

// session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<header>
    <div class="upper-header">
        <div class="upper-header-left">
            <a href="tel:+923101120402">
                <i class="fa-solid fa-phone"></i>
                +92 310 1120402
            </a>
        </div>
        <div class="upper-header-mid">
            <a href="mailto:azam78454@gmail.com">
                <i class="fa-solid fa-envelope"></i>
                azam78454@gmail.com
            </a>
        </div>
        <div class="upper-header-right">
            <i class="fa-solid fa-clock"></i>
            Open Hours: Monday - Sunday 8:00AM - 9:00PM
        </div>
    </div>
    <div class="downer-header">
        <div class="downer-header-left">
            <a href="../index.html"><img src="../img/logo/logo.png" alt="Logo Pic"></a>
        </div>
        <div class="downer-header-mid">
            <a href="../index.php">Home</a>
            <a href="../categories.php">Categories</a>
            <a href="../stories.php">Stories</a>
            <a href="../about_us.php">About</a>
            <a href="../contact_us.php">Contact</a>
            <a href="../book_table.php">Book a Table</a>
        </div>
        <div class="downer-header-right">
            <div class="search-div">
                <a href="javascript:void()"><ion-icon class="ionicon search-bar-opener"  name="search-outline"></ion-icon></a>
                <form class="search-bar">
                    <input type="text" placeholder="Search here...">
                    <button>Search</button>
                </form>
            </div>

            <?php
            if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                echo '<a href="../cart.php"><ion-icon class="ionicon" name="cart-outline"></ion-icon></a>
                    <div class="account">
                        <p class="account-action-list-opener">'.$_SESSION['name'].' <i class="fa-solid fa-sort-down"></i></p>
                        <ul class="account-action-list" id="account-action-list">
                            <li><a href="my_profile.php">My Profile</a></li>
                            <li><a href="../my_addresses.php">My Addresses</a></li>
                            <li><a href="../my_orders.php">My Orders</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>';
            } else {
                echo '<a href="login.php" class="user-link"><i class="fa-regular fa-user"></i></a>';
            }
            
            ?>
            

        </div>
    </div>
    <div class="for-mobile-nav-bar">
        <div class="sides">
            <div class="for-mobile-nav-bar-left">
                <a class="white-logo" href="../index.html"><img src="../img/logo/white_logo.png" alt="Logo Pic"></a>
                <a class="simple-logo" href="../index.html"><img src="../img/logo/logo.png" alt="Logo Pic"></a>
            </div>
            <div class="for-mobile-nav-bar-right">
                <div class="lines bars">
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                </div>
            </div>
        </div>
        <div class="links">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../categories.php">Categories</a></li>
                <li><a href="../stories.php">Stories</a></li>
                <li><a href="../about_us.php">About</a></li>
                <li><a href="../contact_us.php">Contact</a></li>
                <li><a href="../book_table.php">Book a Table</a></li>

                <?php
                
                if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                    echo '<li class="for-mobile-account-action-list-opener">'.$_SESSION['name'].' <i class="fa-solid fa-sort-down"></i></li>
                    <ul class="for-mobile-account-action-list">
                        <li><a href="my_profile.php">My Profile</a></li>
                        <li><a href="../my_addresses.php">My Addresses</a></li>
                        <li><a href="../my_orders.php">My Orders</a></li>
                        <li><a href="../cart.php">Cart</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>';
                } else {
                    echo '<li><a href="login.php" class="login-anchor">Login</a></li>
                    <li><a href="sign_up.php">Sign Up</a></li>';
                }
                
                ?>

                <li class="search-li">
                    <form action="">
                        <input type="text" placeholder="Search Here...">
                        <button type="submit">Search</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>