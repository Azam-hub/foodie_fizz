<?php

require "_config.php";

// PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'mail_sender/vendor/autoload.php';
$mail = new PHPMailer(true);

date_default_timezone_set("Asia/Karachi");
$datetime = date("Y-m-d H:i:s");
$msg = "";

if (isset($_POST['submit'])) {
    // Getting POST request
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $related_to = mysqli_real_escape_string($conn, $_POST['related_to']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Check all fields are filled or not
    if ($name == "" || $email == "" || $phone == "" || $related_to == "" || $subject == "" || $message == "") {
        $msg = danger_msg("All fields are required.");
    } else {
        // Sending mail
        $mail_send = false;
        try {
            $mail->SMTPDebug = 0;                                       
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                    
            $mail->SMTPAuth   = true;                             
            $mail->Username   = $from_email_address;                 
            $mail->Password   = $from_email_address_password;                        
            $mail->SMTPSecure = 'tls';                              
            $mail->Port       = 587;  
        
            $mail->setFrom($from_email_address, 'Foodie Fizz');         // Sender address and name
            $mail->addAddress($from_email_address, "Admin");            // Receiver address and name
            
            $mail->isHTML(true);
            $mail->Subject = 'Query';                                   // Message Subject
            $mail->Body    = '
            Dear <b>Admin</b><br>
            There is a new query from <b style="font-size: 20px;"><q>'.$name.'</q></b>.<br><br>
            The query is realted to <b><q>'.$related_to.'</q></b>. <br>
            The query\'s subject is <b><q>'.$subject.'</q></b>. <br>
            For more details <a href="'.$domain_name.'admin_panel/customers_queries.php">Click here!</a>
            ';                                                          // Message Body
            $mail->send();
            $mail_send = true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Check mail send or not
        if ($mail_send) {

            // Inserting data into database
            $insert_sql = "INSERT INTO `queries` (`name`, `email`, `phone`, `related_to`, `subject`, `message`, `status`, `added_on`) 
            VALUES ('$name', '$email', '$phone', '$related_to', '$subject', '$message', 'opened', '$datetime')";
            $insert_res = mysqli_query($conn, $insert_sql);
    
            if ($insert_res) {
                $msg = success_msg("Your messsage has been sent successfully. We will contact you through phone or email shortly.");
            } else {
                $msg = danger_msg("Something went wrong! Please try again later.");
            }
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

    <title>Contact Us - Foodie Fizz</title>

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
    
    <link rel="stylesheet" href="css/contact_us.css">
</head>
<body>

<div class="head-main-container">

    <?php include "_header.php"; ?>
    <?php echo $msg; ?>

    <section>
        <div class="upper-section">
            <div class="upper-section-left">
                <h1 class="dash"><span class="dash"></span>Contact Us</h1>
            </div>
        </div>
        <div class="downer-section">
            <div class="up">
                <div class="info">
                    <div class="icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="title">Address</div>
                    <div class="description">
                        House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.
                    </div>
                </div>
                <div class="info">
                    <div class="icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="title">Phone</div>
                    <div class="description">
                        Mobile: <a href="tel:+923101120402">+92 310 1120402</a>
                    </div>
                </div>
                <div class="info">
                    <div class="icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="title">E-mail</div>
                    <div class="description">
                        E-mail: <a href="mailto:azam78454@gmail.com">azam78454@gmail.com</a>
                    </div>
                </div>
            </div>
            <div class="down">
                <div class="left">
                    <h1>Get In Connect With Restaurant</h1>
                    <form class="proper-form" method="POST">
                        <div class="name">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter your name">
                        </div>
                        <div class="email">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Enter your email">
                        </div>
                        <div class="phone">
                            <label for="phone">Phone</label>
                            <input type="number" name="phone" id="phone" placeholder="Enter your Phone">
                        </div>
                        <div class="related-to">
                            <label for="select">Related to</label>
                            <select name="related_to" id="select">
                                <option value="">-- Select --</option>
                                <option value="billing">Billing</option>
                                <option value="technical">Technical</option>
                                <option value="food">Food</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="subject">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" id="subject" placeholder="Enter your subject">
                        </div>
                        <div class="message">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" placeholder="Enter your message"></textarea>
                        </div>
                        <div class="btn">
                            <button name="submit" type="submit">Send</button>
                            <img src="img/loading.gif" class="loading-gif" alt="Loading GIF">
                        </div>
                    </form>
                </div>
                <div class="right">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2476.4319982163215!2d67.200660051868!3d24.846924184013467!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjTCsDUwJzUwLjMiTiA2N8KwMTInMDIuMyJF!5e0!3m2!1sen!2s!4v1678835362313!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
    $('form').submit(function () {
        $('.btn .loading-gif').show()
    })
</script>

<!-- Header Footer Js -->
<script src="js/_header_footer.js"></script>

<!-- Ionicon Link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>