<?php 
    require_once '../../../connections/productdb.php';
    require_once '../../../UUID/UUID.php';
    include_once '../../../connections/sendMail.php';
    session_start();

    //data from payment page so these are temporary variables and values:
   
    $status = 200;
    $UUID = new UUID();
    $payment_id = $UUID->paymentID($conn, "PN", 18);
    $orderID = $UUID->orderID($conn, "OD", 18); 


    $user = $_SESSION['user'];

    date_default_timezone_set("Asia/Calcutta");
    $date = date("Y-m-d");
    $time = date("h:i:sa");

    $payment_method = $_SESSION['payment_method'];
    
    $paymentJSON = array(
        "status" => $status,
        "payment_id" => $payment_id,
        "order_id" => $orderID,
        "date" => $date,
        "time" => $time,
        "payment_method" => $payment_method
    );

    $productsJSON = $_SESSION['products'];


    if($_SESSION['ordered'] == true) {
        if($status == 200) {
            $phpObj = array(
                "products" => $productsJSON, 
                "user" => $user, 
                "payment" => $paymentJSON
            );
            $_SESSION['orderDetails'] = $phpObj;
            $json = json_encode($phpObj, JSON_PRETTY_PRINT);
            $user_ID = $user['user_id'];

            
            $deliveryDate = date("Y-m-d", strtotime($date . " +7 days"));

            $success = false;
            while($success == false) {
                try {
                    $updateOrder = "INSERT INTO orders(user_id, order_id, order_json, order_status, delivery) VALUES('{$user_ID}', '{$orderID}', '{$json}', 1,'{$deliveryDate}')";
                    $run = mysqli_query($conn, $updateOrder);
                    

                    $orderUsername = $user['user_name'];
                    $sender = "xfassofashion@gmail.com";
                    $reciver = "xfassofashion@gmail.com";
                    $message = 
                    "
                        <head>
                            <style>
                                *{
                                    margin: 0;
                                    padding: 0;
                                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                                }
                            </style>
                        </head>

                        <div style='background: #fff; color: #000; padding: 3% 4%;' class='mail-main'>
                            <div class='_u2' style='border: 1px solid; padding: 10% 5%;'>
                                <div class='username'><h4>User: {$orderUsername}</h4></div>
                                <hr>
                                <br>
                                <div class='time'><h4>Date: {$date}</h4></div>
                                <hr>
                                <br>
                                <div class='subject'>
                                    <h4>Subject:new order from {$orderUsername} </h4>
                                    <br>
                                    <p style='color: rgba(28, 26, 26, 0.753);'>thingss</p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    ";
                    $subject = "New order from {$orderUsername}";
                    $path = "../../../";

                    sendMail($sender, $reciver, $message, $subject, $path);

                    
                    $success = true;
                }catch(mysqli_sql_exception $e) {
                    echo $e;
                    $orderID = uniqid("hzW3Kn");
                    $success = false;
                }
            }
            $_SESSION['ordered'] = false;

            if($success == true) {
                echo "
                    <script>
                        window.location.href = '../../../profile/u/orders/';            
                    </script>
                ";        
            }
            
        } 
    }else {
        echo "
            <script>
                window.location.href = '../../../cart/cart.php';            
            </script>
        ";
    }

    

    // initiated status = 100
    // success status = 200
    // redirection status = 300
    // failed status = 400
    // server failed status = 500
     
?>