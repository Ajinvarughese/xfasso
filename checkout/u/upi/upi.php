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
                    $subject = "New order from {$orderUsername}";
                    $path = '../../../';

                    $message = "
                        <head>
                            <link rel='preconnect' href='https://fonts.googleapis.com'>
                            <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                            <link href='https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap' rel='stylesheet'>
                        </head>

                        <body style='margin: 0; padding: 0; font-family: 'Montserrat', sans-serif;'>
                            <div style='background: #fff; color: #000; padding: 3% 4%;'>
                                <div style='border: 1px solid; padding: 0% 4%;'>
                                    <div><h4 style='font-weight: 600;'>User: {$orderUsername}</h4></div>
                                    <hr style='border: none; border-top: 1px solid #000;'>
                                    <br>
                                    <div>
                                        <h4 style='font-weight: 600;'>Date: {$date}</h4>
                                        <h4 style='font-weight: 600;'>Time: {$time}</h4>
                                    </div>
                                    <hr style='border: none; border-top: 1px solid #000;'>
                                    <br>
                                    <div>
                                        <h4 style='font-weight: 600;'>Subject: new order from {$orderUsername}</h4>
                                        <br>
                                        <div style='border: 1px solid #c2c2c2; padding: 6px; margin-bottom: 1.7rem;'>
                                            <p style='font-size: clamp(13px, 3vw, 14px);'>Order details:</p>
                                            <hr style='width: 90%; border: none; border-top: 1px solid #c2c2c2;'>
                                            <pre style='word-wrap: break-word; white-space: pre-wrap; font-size: clamp(13px, 3vw, 14px); font-family: 'Montserrat', sans-serif;'>
[
    $json
]
                                            </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                    ";
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