<?php 
    
    if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
        // Show 404 error
        header("Location: ../../errors/errors.php?errorID=404");
        exit();
    }
        
    
    
    require_once './Orders.php';
    require_once '../../connections/productdb.php';


    $userID = 'jiK66347b4a87f8b';
    $orderID = 'wuba66363b919e1ed';
    $get = "SELECT * FROM orders WHERE user_id = '{$userID}'";
    $run = mysqli_query($conn, $get);

    if(mysqli_num_rows($run)>0) {
        
        while($res = mysqli_fetch_assoc($run)) {
        
            $jsonData = $res['order_json'];
            $phpObj = json_decode($jsonData, true);


            $order = new Orders($orderID, $userID, $phpObj);

            $json = $order->getProduct($order->getOrderProduct());
            $arrayJSONproducts['products'][] = $json;
            $json = $order->getUserDetails($order->getOrderProduct());
            $arrayJSONUser['user'] = $json;
            $arrayJSONUser['user']["order_id"] = "$orderID";
        }

        $new_JSON = array();
        foreach ($arrayJSONproducts['products'] as $sub_array) {
            foreach ($sub_array as $product) {
                $new_JSON["products"][] = $product;
            }
        }
        $finalJSON = array_merge($new_JSON, $arrayJSONUser);
        $json_output = json_encode($finalJSON, JSON_PRETTY_PRINT);

        echo $json_output;
    
    }

    
?>