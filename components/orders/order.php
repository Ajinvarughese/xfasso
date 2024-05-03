<?php 
    require_once './Orders.php';
    require_once '../../connections/productdb.php';

    $userID = 'jiK66347b4a87f8b';
    $orderID = 'wuba6635108d70c29';
    $get = "SELECT * FROM orders WHERE order_id = '{$orderID}'";
    $run = mysqli_query($conn, $get);

    if(mysqli_num_rows($run)>0) {
        $res = mysqli_fetch_assoc($run);
        $jsonData = $res['order_json'];
        $phpObj = json_decode($jsonData, true);

        $order = new Orders($orderID, $userID, $phpObj);

        $order->getProduct($order->getOrderProduct());
    }

    
?>