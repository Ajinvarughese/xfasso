<?php 
    require '../../../../connections/productdb.php';


    if(isset($_COOKIE['XassureUser'])) {
        $emailId = $_COOKIE['XassureUser'];

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
            $user_id = $row["user_id"];
            $username = $row["username"];
        }else {
            echo "<script>
                document.cookie='XassureUser=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                window.location.href = '../../../../signup/signup.html';
                </script>";
        }

        if(isset($_GET['orderID']) && isset($_GET['productID'])) {
            $orderID = $_GET['orderID'];
            $productID = $_GET['productID'];
            
            $ciphering = "AES-128-CTR"; 
            $options = 0;
            //decrypting
            $decryption_iv = '1234567891021957';
            $decryption_key = "xfassoKey";
            $decrypted_id = openssl_decrypt($productID, $ciphering, $decryption_key, $options, $decryption_iv);  
            
            $splitId = explode(' ', $decrypted_id);

            $decrypted_id = $splitId[1];

            $quer = "SELECT * FROM orders WHERE order_id ={$orderID} AND user_id='{$user_id}'";
            $runQ = mysqli_query($conn, $quer);
            if(mysqli_num_rows($runQ)>0) {
                $res = mysqli_fetch_assoc($runQ);
                $phpObj = json_decode($res['order_json'], true);
                
                for($i=0; $i<count($phpObj['products']); $i++) {
                    $ObjProdID = $phpObj['products'][$i]['product_id'];
                    
                    if($decrypted_id == $ObjProdID) {
                        $decrypted_id = $ObjProdID;
                        $title = $phpObj['products'][$i]['product_name'];
                        break;
                    }
                }

                $orderID = $phpObj['payment']['order_id'];
                $paymentID = $phpObj['payment']['payment_id'];
                $userDetails = $phpObj['user'];
                
                
                $deliveryDate = date("F d", strtotime($res['delivery']));
                $orderDate = date("F d, Y", strtotime($res['date']));
                $orderDate2 = date("F d", strtotime($orderDate));
            }
        }else {
            echo "
                <script>
                    window.history.back();
                </script>
            ";
        }

    }else {
        header('Location: ../../../../signup/signup.html');
    }  

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order - <?php echo $title; ?> </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       


    <link rel="stylesheet" href="../css/order-details.css">

    <style>
        *{
            font-size: clamp(14.7px, 2.5vw, 16.4px);
        }
        .id {
            opacity: 0.9;
            font-size: 14px;
            font-weight: 300;
        }
        .id span {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div style="cursor: pointer;" onclick="user(false)" id="back" class="back">
            <img src="../../../../resources/left-arrow.png" width="32px">
        </div>
        <div class="logo">
            <h2>XFASSO</h2>
        </div>
        <div class="prof">
            <div onclick="user(true)" id="user" class="user">
                <img src="../../../../resources/user.png" alt="user image">
            </div>
            
            <div class="cart">
                <a href="../../../../cart/cart.php" id="zIca" style="text-decoration: none; color: inherit;">
                    <img id="cartImage" src="../../../../resources/cart-white.png" alt="cart">
                    
                    <div id="cart_num">
                        <div id="number"></div>
                    </div>
                    <script>
                        var cart_num = document.getElementById('cart_num');
                        var number = document.getElementById('number');
                        fetch('../../../../num/num.php')
                            .then((result) => {
                                return result.json(); 
                            })
                            .then((outcome) => {
                                number.innerHTML = outcome.num;
                                if(outcome.num === 0) {
                                    cart_num.style.display = 'none';
                                }

                                if(outcome.num < 100) {
                                    cart_num.style.width = '18px';
                                    cart_num.style.height = '18px';
                                    cart_num.style.fontSize = '12px';
                                }else {
                                    cart_num.style.fontSize = '7.4px';
                                }
                            })
                            .catch((error)=> {
                                cart_num.style.display = 'none';  
                            })
                    </script>
                </a>
            </div>
        </div>
    </div>
    <style>
        .main {
            max-width: 940px;
            display: block;
            margin: 0 auto;
        }  

        .prodImg {
            max-width: 120px;
            max-height: 140px;
        }
        .prodImg img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        .orderID {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        .card {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 0.6rem 2%;
        }
        .date {
            font-weight: 500;
        }
        .orderDetails {
            display: flex;
            
        }
        .del, .card{
            flex-grow: 1;
        }
        .date {
            border: 1px solid;
        }
        .tiasd {
            font-weight: 600;
        }
        .ainw {
            margin-top: 9px;
        }
        .ainw >div {
            margin-top: 6px;
        }
        .content span {
            opacity: 0.8;
            font-size: calc(1em - 1.6px);
        }
        .imp {
            border-bottom: 1px solid #c2c2c2c2;
            padding: 21px 7px 12px 7px;
            font-weight: 300;
        }
        .imp p:nth-child(2) {
            margin-top: 4px;
        }
        .orderID {
            margin-top: 1.3rem;
            padding: 0 7px;
            font-weight: 400;
            border-bottom: 1px solid #c2c2c2c2;
            padding-bottom: 0.5rem;
        }
        .orderID span {
            opacity: 0.8;
            font-weight: 500;
        }
        .orderID span,.orderID p {
            font-size: calc(1em - 1.5px);
        }
        .orderDetails {
            padding: 0 7px;
        }
        .del {
            padding: 0.6rem 7px;
            border: 1px solid;
        }

        @media (max-width: 762px) {
            .orderDetails {
                flex-direction: column;
            }
        }
    </style>
    <div class="main">
        <div class="imp">
            <p>order is made for <?php echo $userDetails['user_name'] ?></p>
            <p>ordered on <?php echo $orderDate?></p>
        </div>
        <div class="orderID">
            <span>order id: </span><p> &nbsp;<?php echo $orderID;?></p>
        </div>
        <div class="orderDetails">
            <div class="card">
                <div class="content">
                    <div class="tiasd">HELIX</div>

                    <div class="ainw">
                        <div class="size"> <span>size: </span>  M</div>
                        <div class="quantity"><span>quantity: </span>  4</div>
                        <div class="price"><span>price: </span> ₹599</div>
                    </div>
                    
                </div>
                <div class="prodImg">
                    <img src="../../../../download.jpeg" alt="">
                </div> 
            </div>
            <div class="del">
                <div class="date">
                    <div class="scale">long scale</div>
                    <div class="dateForm">
                        <div class="orderDate">
                            Order Confirmed
                            <?php echo $orderDate2;?>
                        </div>
                        <div class="expected">
                            Expected delivery
                            <?php echo $deliveryDate; ?>
                        </div>
                    </div>
                </div>
                <div style="font-size: 12px; opacity:0.7;" >
                    *delivery date may vary according to the provider 
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function user(x) {
        if(x === true) { 
            window.location.href = '../../edit-profile.php';
        }
        else {
            window.history.back();
        }
    }
</script>
<script src='../main.js'></script>
</html>