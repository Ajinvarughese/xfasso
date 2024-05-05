<?php 
    
    require_once './Orders.php';
    require_once '../../connections/productdb.php';

    //user
    $emailId = $_COOKIE['XassureUser'];

    //decryption
    $ciphering = "AES-128-CTR";
    $options = 0;
    $decryption_iv = '1234567891021957';
    $decryption_key = "xfassoKey";
    $decryptedEmail_id = openssl_decrypt($emailId, $ciphering, $decryption_key, $options, $decryption_iv);
    $email = $decryptedEmail_id;

    $querUser = "SELECT * FROM users WHERE email = '$email'";
    $runUser = mysqli_query($conn, $querUser); 
    $res = mysqli_fetch_assoc($runUser);
    $userID = $res['user_id'];
    

    
    $querOrder = "SELECT * FROM orders WHERE user_id='$userID'";
    $runOrder = mysqli_query($conn, $querOrder);
    $res = mysqli_fetch_assoc($runOrder);
    $orderID = $res['order_id'];
    
    
    $get = "SELECT * FROM orders WHERE user_id = '{$userID}'";
    $run = mysqli_query($conn, $get);

    if(mysqli_num_rows($run)>0) {
        
        while($res = mysqli_fetch_assoc($run)) {
        
            $jsonData = $res['order_json'];
            $phpObj = json_decode($jsonData, true);

            $i=0;
            while(isset($phpObj['products'][$i]['product_id'])) {
                $prodID = $phpObj['products'][$i]['product_id'];
                $quer = "SELECT product_image FROM products WHERE product_id = {$prodID}";
                $res = mysqli_query($conn, $quer);
                $row = mysqli_fetch_assoc($res);
                $imageData = base64_encode($row['product_image']);
                $phpObj['products'][$i]['product_image'] = $imageData;
                $i++;
            }


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
    }else {
        $json_output = "";
    }

    echo $json_output;

    
?>