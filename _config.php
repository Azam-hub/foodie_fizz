<?php

date_default_timezone_set("Asia/Karachi");

$server = "localhost";
$username = "root";
$password = "";
$database = "foodie_fizz";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    echo "Couldnot Connect to database";
}

// ------------------------ Domain Name ------------------------

$domain_name = "http://localhost:8080/Food_website/";

// ------------------------ Domain Name ------------------------

$from_email_address = "legendhacker422@gmail.com";
$from_email_address_password = "ggmlwbsefifjvmoo";

// ------------------------ Messages Function -------------------------

function success_msg($msg) {
    $text = '<div class="msg success-msg">
                <div class="left">
                    <ion-icon class="icon" name="checkmark-circle-outline"></ion-icon>
                </div>
                <div class="right">
                    <p>'.$msg.'</p>
                </div>
            </div>';
    return $text;
}
function danger_msg($msg) {
    $text = '<div class="msg danger-msg">
                <div class="left">
                    <ion-icon class="icon" name="alert-circle-outline"></ion-icon>
                </div>
                <div class="right">
                    <p>'.$msg.'</p>
                </div>
            </div>';
    return $text;
}
function primary_msg($msg) {
    $text = '<div class="msg primary-msg">
                <div class="left">
                    <ion-icon class="icon" name="checkmark-circle-outline"></ion-icon>
                </div>
                <div class="right">
                    <p>'.$msg.'</p>
                </div>
            </div>';
    return $text;
}


?>