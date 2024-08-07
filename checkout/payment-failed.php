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
                header('Location: ../errors/error.php?errorId=');
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
    <title>Payment Failed</title>
</head>
<body>
    <h1>Payment Failed!</h1>
    
</body>
</html>