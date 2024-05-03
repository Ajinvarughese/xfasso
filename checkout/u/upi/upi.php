<?php 
    require_once '../../../connections/productdb.php';
    session_start();

    //data from payment page so these are temporary variables and values:
   
    $status = 200;
    $payment_id = uniqid('iaen');
    $orderID = uniqid("wuba"); 


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


            // $success = false;
            // while($success == false) {
                try {
                    $updateOrder = "INSERT INTO orders(user_id, order_id, order_json, status) VALUES('{$user_ID}', '{$orderID}', '{$json}', $status)";
                    $run = mysqli_query($conn, $updateOrder);
                    $success = true;
                }catch(mysqli_sql_exception $e) {
                    echo $e;
                    $orderID = uniqid("hzW3Kn");
                    $success = false;
                }
            //}
            $_SESSION['ordered'] = false;

            if($success == true) {
                echo "
                    <script>
                        window.location.href = '../../../';            
                    </script>
                ";        
            }
            
        } 
    }else {
        echo "
            <script>
                window.location.href = '../../../';            
            </script>
        ";
    }

    

    // initiated status = 100
    // success status = 200
    // redirection status = 300
    // failed status = 400
    // server failed status = 500
     
?>