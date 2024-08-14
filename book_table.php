<?php

require "_config.php";

$msg = "";

date_default_timezone_set("Asia/Karachi");
$real_datetime = date("Y-m-d H:i:s");

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $month = mysqli_real_escape_string($conn, $_POST['month']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    $hour = mysqli_real_escape_string($conn, $_POST['hour']);
    $minute = mysqli_real_escape_string($conn, $_POST['minute']);
    $am_pm = mysqli_real_escape_string($conn, $_POST['am-pm']);

    $person = mysqli_real_escape_string($conn, $_POST['person']);

    if ($name == "" || $email == "" || $phone == "" || $date == "" || $date == "null" || $month == "" || 
    $year == "" || $hour == "" || $minute == "" || $am_pm == "" || $person == "" || $person == "null") {
        $msg = danger_msg("All fields are required.");
    } else {
    
        $time_in_12_hour_format = $hour.':'.$minute.' '.$am_pm;
        $time_in_24_hour_format = date("H:i", strtotime($time_in_12_hour_format));
    
        $datetime = $year.'-'.$month.'-'.$date.' '.$time_in_24_hour_format;
    
        $insert_sql = "INSERT INTO `table_booking` (`name`, `email`, `phone`, `person`, `reserved_for`, `status`, `added_on`) 
        VALUES ('$name', '$email', '$phone', '$person', '$datetime', 'pending', '$real_datetime')";
        $insert_res = mysqli_query($conn, $insert_sql);
    
        if ($insert_res) {
            // $msg = success_msg("Your table reservation request has been sent successfully.");
            $msg = success_msg("Your table has been reserved successfully.");
        } else {
            $msg = danger_msg("Something went wrong! Please try again later.");        
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

    <title>Book a Table - Foodie Fizz</title>

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
    <link rel="stylesheet" href="css/_form.css">
    
    <link rel="stylesheet" href="css/book_table.css">
</head>
<body>

<div class="head-main-container" id="head-main-container">

    <?php include "_header.php"; ?>

    <?php echo $msg; ?>
    
    <div class="js-msg"></div>
    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Book a Table</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="left">
                <!-- <h2>Table Reservation</h2> -->
                <form class="proper-form" method="POST">
                    <div class="form-sections name">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name">
                    </div>
                    <div class="form-sections email">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-sections phone">
                        <label for="phone">Phone</label>
                        <input type="number" id="phone" name="phone" placeholder="Enter your phone number">
                    </div>
                    <div class="form-sections date date-divs">
                        <!-- <label for="date">Date</label>
                        <div class="selects">

                            <select name="" id="date-select">
                                <option value="">-- Date --</option>
                            </select>
                            <select name="" id="month-select">
                                <option value="">-- Month --</option>
                                <option value='Janaury'>Janaury</option>
                                <option value='February'>February</option>
                                <option value='March'>March</option>
                                <option value='April'>April</option>
                                <option value='May'>May</option>
                                <option value='June'>June</option>
                                <option value='July'>July</option>
                                <option value='August'>August</option>
                                <option value='September'>September</option>
                                <option value='October'>October</option>
                                <option value='November'>November</option>
                                <option value='December'>December</option>
                            </select>
                            <select name="" id="year-select">
                                <option value="">-- Year --</option>
                            </select>

                        </div> -->

                        <div class="year">
                            <label for="year">Year</label>
                            <select name="year" id="year-select">
                                <option value="null">-- Year --</option>
                            </select>
                        </div>
                        <div class="month">
                            <label for="month">Month</label>
                            <select name="month" id="month-select">
                                <option value="null">-- Month --</option>
                                <option value='01'>Janaury</option>
                                <option value='02'>February</option>
                                <option value='03'>March</option>
                                <option value='04'>April</option>
                                <option value='05'>May</option>
                                <option value='06'>June</option>
                                <option value='07'>July</option>
                                <option value='08'>August</option>
                                <option value='09'>September</option>
                                <option value='10'>October</option>
                                <option value='11'>November</option>
                                <option value='12'>December</option>
                            </select>
                        </div>
                        <div class="date">
                            <label for="date">Date</label>
                            <select name="date" id="date-select">
                                <option value="null">-- Date --</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-sections time">
                        <label for="time">Time</label>
                        <div class="time-selects">

                            <select name="am-pm" id="am-pm-select">
                                <option value="pm" selected>P.M.</option>
                                <option value="am">A.M.</option>
                            </select>
                            <select name="hour" id="hour-select">
                                <option value="">-- Hour --</option>
                            </select>
                            <select name="minute" id="minute-select">
                                <option value="">-- Minute --</option>
                            </select>
                            

                        </div>
                    </div>
                    <div class="form-sections person">
                        <label for="person">Person</label>
                        <select name="person" id="">
                            <option value="null">-- Person --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="4+">4+</option>
                        </select>
                    </div>
                    
                    <div class="form-sections btn">
                        <button type="submit" name="submit">Reserve</button>
                    </div>
                </form>
            </div>
            <div class="right">
                <img src="img/book_table/book_table.jpg" alt="">
            </div>
        </div>
    </section>
    
    <?php include "_footer.php"; ?>
</div>
    
</body>

<!-- jQuery -->
<script src="jquery/jquery-3.6.1.min.js"></script>

<script>

    // Date methods
    var current_year = new Date().getFullYear()
    for (let i = 0; i <= 4; i++) {
        $("#year-select").append(`<option value="${current_year + i}">${current_year + i}</option>`)
    }
    
    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    var selected_year = 'null';
    $('#year-select').change(function () {
        // var selected_year = $('#year-select').find(":selected").val();
        selected_year = $('#year-select option:selected').val();
    })

    var selected_month = 'null';
    $('#month-select').change(function () {
        // var selected_year = $('#year-select').find(":selected").val();
        selected_month = $('#month-select option:selected').val();

        if (selected_month != 'null' && selected_year != 'null') {
            
            let number_of_days = getDaysInMonth(selected_month, selected_year)
            for (let i = 1; i <= number_of_days; i++) {
    
                if (i == 1) {
                    $("#date-select").html('')
                    $("#date-select").append(`<option value="null">-- Date --</option>`)
                }
                $("#date-select").append(`<option value="${i}">${i}</option>`)
            }
        }
    })

    $("#date-select").click(function () {
        
        if (selected_year == "null") {
            
            let html = `<div class="msg danger-msg">
                            <div class="left">
                                <ion-icon class="icon md hydrated" name="alert-circle-outline" role="img" aria-label="alert circle outline"></ion-icon>
                            </div>
                            <div class="right">
                                <p>Please select Year first!</p>
                            </div>
            </div>`;
            
            $(".js-msg").html(html)
            location.hash = 'head-main-container'

            setTimeout(() => {
                if(typeof window.history.pushState == 'function') {
                    window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
                }
            }, 500);

        } else if (selected_month == "null"){
            
            let html = `<div class="msg danger-msg">
                            <div class="left">
                                <ion-icon class="icon md hydrated" name="alert-circle-outline" role="img" aria-label="alert circle outline"></ion-icon>
                            </div>
                            <div class="right">
                                <p>Please select Month first!</p>
                            </div>
            </div>`;
            
            $(".js-msg").html(html)
            location.hash = 'head-main-container'

            setTimeout(() => {
                if(typeof window.history.pushState == 'function') {
                    window.history.pushState({}, "Hide", "<?php echo $_SERVER['PHP_SELF'];?>");
                }
            }, 500);

        }
    })


    // Time Options
    var am_pm = 'pm';
    $("#hour-select").append(`<option value="12">12</option>`)
    for (let i = 1; i <= 11; i++) {
        $("#hour-select").append(`<option value="${i}">${i}</option>`)
    }
    $('#am-pm-select').change(function () {
        am_pm = $('#am-pm-select option:selected').val();

        if (am_pm == 'pm') {
            $("#hour-select").html('')
            $("#hour-select").append(`<option value="null">-- Hour --</option>`)
    
            $("#hour-select").append(`<option value="12">12</option>`)
            for (let i = 1; i <= 11; i++) {
    
                $("#hour-select").append(`<option value="${i}">${i}</option>`)
            }
    
        } else if (am_pm == 'am') {
            $("#hour-select").html('')
            $("#hour-select").append(`<option value="null">-- Hour --</option>`)
    
            $("#hour-select").append(`<option value="12">12</option>`)
            $("#hour-select").append(`<option value="11">11</option>`)
        }
    })

    for (let i = 0; i <= 59; i++) {
        $("#minute-select").append(`<option value="${('0' + i).slice(-2)}">${('0' + i).slice(-2)}</option>`)
    }
</script>

<!-- Header Footer Js -->
<script src="js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>