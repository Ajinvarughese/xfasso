<?php 
    session_start();
    require('../connections/productdb.php');
    require_once '../UUID/UUID.php';
    require_once '../checkexistence/checkExistence.php';

    if(isset($_COOKIE['XassureUser'])) {
        $emailId = mysqli_escape_string($conn, $_COOKIE['XassureUser']);
        $cookiePassword = mysqli_escape_string($conn, $_COOKIE['X9wsWsw32']);

        if(checkUserExistence($conn, $emailId, $cookiePassword) == false) {
            header('Location: ../signup/signup.html');
        }

        //decrypting
        $ciphering = "AES-128-CTR";
        $options = 0;
        $decryption_iv = '1234567891021957';
        $decryption_key = "xfassoKey";
        $decrypted_id = openssl_decrypt($emailId, $ciphering, $decryption_key, $options, $decryption_iv);
        $email = $decrypted_id;

        $qTitle = "SELECT * FROM users WHERE email='$email'";
        $res = mysqli_query($conn, $qTitle);
        if(mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $userId = $row["user_id"];
            $username = $row["username"];

            date_default_timezone_set("Asia/Calcutta");
            $date = date("Y-m-d");
            $time = date("h:i:sa");

            $dateTime = $date.' '.$time;
            $status = $_SESSION['status'];

            $uuid = new UUID();
            $paymentId = $uuid->paymentId($conn, "PAY", 18);

            $razorpayID = $_SESSION['razorpay_id'];
            $productsPHPObjects = $_SESSION['products'];
            $products = json_encode($productsPHPObjects, JSON_PRETTY_PRINT);
            
            session_destroy();

            if(isset($status) && ($status == 400)) {
                $quer = "INSERT INTO payments (payment_id, razorpay_payment_id, user_id, products, date, status) 
                        VALUES('$paymentId', '$razorpayID', '$userId', '$products', '$dateTime', $status)"; 
                $runQ = mysqli_query($conn, $quer);

            }else {
                header('Location: ../errors/error.php?errorId=404');
            }
        }else {
            header('Location: ../signup/signup.html');
        }

    }else {
        header('Location: ../signup/signup.html');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Payment Failed</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            color: #12263a;
        }
        .failedMain {
            min-height: 560px;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #dd3938;
        }
        .card {
            border-radius: 8px;
            border: 1px solid #fff;
            max-width: 490px;
            background: #fff;
            padding: 3.4rem 2rem;
        }
        .imgIcon {
            width: 62px;
            height: 62px;
        }
        .imgIcon img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        .failedMain p {
            font-weight: 500;
            font-size: 15px;   
        }
        .failedMain button {
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            margin: 1rem 0;
            box-shadow: 0 5px 14px -6px #12263a;
            padding: 14px 27px;
            background: #12263a;
            outline: none;
            border: none;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .failedMain button:hover {
            transform: scale(1.03);
        }
        .supp {
            display: flex;
            gap: 0.3rem;
        }
        .supp p, .supp span{
            font-weight: 600;
            font-size: 13px;
        }
        .supp span {
            color: #4c72e0;
            cursor: pointer;
        }
        .footer, .email-us {
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="failedMain">
        <div class="card">
            <div class="imgIcon">
                <img src="../resources/warning-signal.png" alt="warning">
            </div>
            <h1>Payment Failed</h1>
            <br>
            <p>🥺Hey there. We are sadly informing you that your purchase has been cancelled ❌ due to failure in payment. It may have occured due to any invalid inputs, unauthorized inputs or other technical issues 💻. </p>
            <button onclick="window.location.replace('../')">Go back to home</button>
            <div class="supp">
                <p>Have a question?</p><span onclick="window.location.replace('../contact/')">contact support</span>
            </div>
        </div>
    </div>

    <hr class="_y72">
        <div class="footer">
            <div class="quick-link">
                <h4 class="primary footer-head">Quick links</h4>
                <ul>
                    <li><a onclick="menCookie()" href="../shop/shop.php">Men</a></li>
                    <li><a onclick="womenCookie()" href="../shop/shop.php">Women</a></li>
                    <li><a href="../shop/shop.php">Shop All</a></li>
                </ul>
            </div>
            <div class="info">
                <h4 class="primary footer-head">Info</h4>
                <ul>
                    <li><a href="../about/">About</a></li>
                    <li><a href="../policies/shipping/">Shipping policy</a></li>
                    <li><a href="../policies/return/">Return policy</a></li>
                    <li><a href="../policies/terms/">Terms and Conditions</a></li>
                    <li><a href="../policies/privacy/">Privacy policy</a></li>
                </ul>
            </div>
            <div class="our-mission">
                <h4 class="primary footer-head">Our mission</h4>
                <p class="secondary">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum quibusdam alias excepturi corporis fuga aut beatae amet repudiandae. Commodi, placeat earum</p>
            </div>
        </div>
        <div id="email-us" class="email-us">
            <h1 class="primary">Email Us.</h1>
            <form action="../connections/mailto.php" method="post">
                <input type="text" id="sug" class="_i044d" name="email-text" value="" required placeholder="Your suggetions goes here">
                <input type="submit" name="submit" onclick="emailSubmit()" id="email-submit">
                <label for="email-submit" class="btn-email">
                    <img src="../resources/icons8-arrow.gif" alt="->">
                </label>
                <p id="emailSending" class="emailSending secondary"></p>
                <br>
                <br><br>
                <ul style="display: flex; justify-content: center;" class="new-nav-social-links">
                    <li>
                        <a href="#" class="_u2c">
                            <img src="../resources/socialmedia/icons8-instagram-48.png" width="24px" alt="instagram">
                        </a>
                    </li>
                    <li><a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-facebook-48.png" width="24px" alt="facebook">
                    </a></li>
                    <li><a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-pinterest-48.png" width="24px" alt="pinterest">
                    </a></li>
                    <li><a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-twitterx-50.png" width="24px" alt="twitter X">
                    </a></li>
                </ul>
            </form>
            <p class="_c45 secondary">&copy; xfasso 2024</p>
        </div>

        <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(";").shift();
        }

        var emailSending = document.getElementById("emailSending");
        var sug =document.getElementById("sug");
        function emailSubmit() {
            emailSending.textContent = "Sending email...";
            emailSending.style.display = "block";
        }

        if (getCookie("message-sent")) {
            emailSending.style.display = "block";
            emailSending.textContent = "email send succesfully...";
            setTimeout(() => {
                emailSending.style.display = "none";
                sug.value = '';
                document.cookie =
                "message-sent=messageSentTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
            }, 4000);
        }

        function menCookie() {

            var cookieExpires = new Date(Date.now() + 100 * 30).toUTCString();
            document.cookie = "men-checked=menTrue; expires="+ cookieExpires +"; path=/";
        }
        function womenCookie() {
            var cookieExpires = new Date(Date.now() + 100 * 30).toUTCString();
            document.cookie = "women-checked=womenTrue; expires="+ cookieExpires +"; path=/";
        }

    </script>
</body>
</html>