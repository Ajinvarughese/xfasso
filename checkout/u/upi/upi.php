<?php 
    require_once '../../../connections/productdb.php';
    require_once '../../../UUID/UUID.php';
    session_start();
    include "../../../phpmailer/src/Exception.php";
    include "../../../phpmailer/src/PHPMailer.php";
    include "../../../phpmailer/src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //data from payment page so these are temporary variables and values:
   
    $status = $_SESSION['status'];
    $_SESSION['status'] = '';


    if($_SESSION['ordered'] == true) {
        $_SESSION['ordered'] = false;
        if($status == 200) {

            $UUID = new UUID();
            $orderID = $UUID->orderID($conn, "ODR", 18); 


            $user = $_SESSION['user'];

            date_default_timezone_set("Asia/Calcutta");
            $date = date("Y-m-d");
            $time = date("h:i:sa");

            $payment_method = $_SESSION['payment_method'];
            $payment_id = $_SESSION['payment_id'];

            $paymentJSON = array(
                "status" => $status,
                "payment_id" => $payment_id,
                "order_id" => $orderID,
                "date" => $date,
                "time" => $time,
                "payment_method" => $payment_method
            );
            

            $productsJSON = $_SESSION['products'];


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

                    sendMail($sender, $reciver, $message, $subject);
                    
                    $orderDate = date("F j, Y");

                    $messageForUser = forUser($orderID, $orderDate, $phpObj['products'], $orderUsername);
                    $userMail = $phpObj['user']['email'];
                    $subjForUser = "Hey {$orderUsername}, your order is confirmed!";
                    sendMail($sender, $userMail, $messageForUser, $subjForUser);

                    $success = true;
                }catch(mysqli_sql_exception) {
                    $orderID = $UUID->orderID($conn, "OD", 18); 
                    $success = false;
                }
                $_SESSION['ordered'] = false;
            }
            if($success == true) {
                echo "
                    <script>
                        window.location.href = '../../../profile/u/orders/';            
                    </script>
                ";        
            }
        }else {
            $_SESSION['status'] = 400;
            echo "
                <script>
                    window.location.href = '../../payment-failed.php';            
                </script>
            ";
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

    

    function sendMail($sender, $reciver, $message, $subject) {        
        
        try {
            
            date_default_timezone_set("Asia/Kolkata");
            $date = date("d-m-Y h:i:s A");
            
            
            $mail = new PHPMailer(true);

            $mail -> isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'xfassofashion@gmail.com';
            $mail->Password = 'efoovowwgtdoxrih';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom($sender); // the sended from email

            $mail->addAddress($reciver); //the send to email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();

        }
        catch(Exception) {
            echo "
                <script>
                    window.location.href = '../../../errors/errors.php?errorID=1025';
                </script>
            ";
        }

    }



    function totalProd($productDetails) {
        $message = "";
        for($i=0; $i<count($productDetails); $i++) {
            $prodName = $productDetails[$i]['product_name'];
            $quant = $productDetails[$i]['quantity'];
            $price = $productDetails[$i]['product_price'];

            $message .= "
                <tr>
                    <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>{$prodName}</td>
                    <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>{$quant}</td>
                    <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>₹{$price}</td>
                </tr>
            ";
        }
        return $message;
    }

    function forUser($orderID, $orderDate, $productDetails, $username) {
        $totalPrice = 0;
        for($i=0; $i<count($productDetails); $i++) {
            $totalPrice += $productDetails[$i]['product_price']*$productDetails[$i]['quantity'];
        }
        $message = "
            <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Order Confirmation</title>
                </head>
                <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
                    <div style='width: 90%; padding: 20px; background-color: #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
                        <div style='background-color: #4CAF50; color: #ffffff; padding: 20px; text-align: center;'>
                            <h1 style='margin: 0;'>Order Confirmation</h1>
                        </div>
                        <div style='padding: 20px;'>
                            <p>Dear {$username},</p>
                            <p>Thank you for your order! We are pleased to confirm that your order has been successfully processed.</p>
                            <div style='text-align: center; margin: 20px 0;'>
                                <h2 style='margin: 0;'>Order Summary</h2>
                                <p>Order ID: <strong>{$orderID}</strong></p>
                                <p>Order Date: <strong>{$orderDate}</strong></p>
                            </div>
                            <table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>
                                <thead>
                                    <tr>
                                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px; background-color: #f2f2f2;'>Product</th>
                                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px; background-color: #f2f2f2;'>Quantity</th>
                                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px; background-color: #f2f2f2;'>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ".
                                    totalProd($productDetails)
                                .
                                "
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan='2' style='border: 1px solid #dddddd; text-align: left; padding: 8px; background-color: #f2f2f2;'>Total</th>
                                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>₹{$totalPrice}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <p>If you have any questions about your order, feel free to <a href='mailto:support@example.com'>contact our support team</a>.</p>
                            <p>You can track your order status at any time using the button below:</p>
                            <p style='text-align: center;'>
                                <a href='https://www.example.com/track-order' style='display: inline-block; padding: 10px 20px; margin: 20px 0; color: #ffffff; background-color: #4CAF50; text-decoration: none; border-radius: 5px;'>Track Order</a>
                            </p>
                        </div>
                        <div style='background-color: #f2f2f2; padding: 10px; text-align: center;'>
                            <p style='margin: 0;'>&copy; xfasso 2024. All rights reserved.</p>
                            <p style='margin: 0;'><a href='https://www.example.com/privacy-policy' style='color: #4CAF50; text-decoration: none;'>Privacy Policy</a> | <a href='https://www.example.com/terms' style='color: #4CAF50; text-decoration: none;'>Terms of Service</a></p>
                        </div>
                    </div>
                </body>
                </html>
        ";
        
        return $message;   
    }

    
     
?>