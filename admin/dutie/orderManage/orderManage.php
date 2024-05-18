<?php 
session_start();
require_once '../../../connections/productdb.php';


if(empty($_SESSION['XQCLANG'])){
    header('Location: ../../admin-login/');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>

     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="../../style.css">
</head>
<body>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
            color: #121b12df;
        }
        
        .back {
            width: 42px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .back:hover {
            transform: scale(1.07);
        }
        .back img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        .logo h2{
            font-size: 19px;
        }

        .omMain {
            padding: 5.8rem 2%;
        }
        .omMain h1{
            font-size: x-large;
            width: fit-content;
        }
    </style>    
    <div class="nav">
        <div onclick="goBack()" class="back">
            <img src="../../images/back.png" alt="back">
        </div>
        <div class="logo"><h2>XFASSO<h2></div>
        <div id="drop" class="admin">
            <div class="prof">
                <img src="../../../resources/user.png" alt="user">
            </div>
            <div id="showDrop" class="dropDown">
                <p><span>Status: </span><span class="gr"></span>Online</p>
                <hr>
                <p><span>ID:</span> <?php echo $_SESSION['XQCLANG'];?></p>
                <hr>
                <p><span>Work: </span><?php echo $_SESSION['myWork'];?></p>
                <hr>
                <button id="logOut">Logout</button>
            </div>
        </div>
    </div>
    <style>
        .prodCard {
            margin-top: 1.6rem;
            max-width: 600px;
            display: flex;
            flex-direction: column-reverse;
        }
        .card {
            margin-top: 0.8rem;
            border: 1px solid #c2c2c2c2;
            border-radius: 4px;
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            justify-content: space-between;
            transition: 0.3s ease;
            cursor: pointer;
        }
        .card:hover {
            transform: scale(1.019);
            border: 1px solid #121b12df;
        }
        .cardImg {
            padding: 4px;
            max-width: 64px;
        }
        .cardImg img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            border-radius: 4px;
        }
        .cont {
            display: flex;
            flex-wrap: wrap;
            padding-right: 8px;
        }
        .cont > div {
            margin-left: 9px;
            font-size: 13px;
        }
        .c {
            text-decoration: none;
        }
        .t >span {
            font-weight: 600 !important;
            font-size: 13px;
        }
        .orderStatus {
            
        }
        .inpBtn {

        }
        .in {
            font-size: 13px;
            width: fit-content;
        }
    </style>
    <div class="omMain">
        <h1>Current orders
            <hr>
        </h1>
        <div class="search"></div>
        <div class="prodCard">
            <?php 

                $q = "SELECT * FROM orders";
                $e = mysqli_query($conn, $q);
                if(mysqli_num_rows($e)>0) {
                    while($res=mysqli_fetch_assoc($e)) {
                        $order_status = $res['order_status'];
                        $style1 = '';
                        $style2 = '';
                        if($order_status == 3) {
                            $style1 = 'background: #121b12df;';
                            $style2 = 'color:#fff;';
                        }

                        $orderPHPobj = json_decode($res['order_json'], true);

                        $username = $orderPHPobj['user']['user_address']['fullName'];
                        $user_id = $orderPHPobj['user']['user_id'];
                        $order_id = $res['order_id'];
                        $payment_id = $orderPHPobj['payment']['payment_id'];
                        $order_status = $res['order_status'];
                        $order_date = $orderPHPobj['payment']['date'];

                        for($i=0; $i<count($orderPHPobj['products']); $i++) {
                            $product_id = $orderPHPobj['products'][$i]['product_id'];
                            echo "
                                <a href='editorder.php?product_id={$product_id}&order_id=$order_id&user_id=$user_id' class='c'>
                                    <div style='$style1' class='card'>
                                        <div class='cardImg'>
                                            <img src='../../../download.jpeg' alt='product image'>
                                        </div>
                                        <div class='contas'>
                                            <div class='cont'>
                                                <div style='$style2' class='t'>username: <span style='$style2'>$username</span></div>
                                                <div style='$style2' class='t'>user id: <span style='$style2'>$user_id</span></div>
                                                <div style='$style2' class='t'>order_id: <span style='$style2'>$order_id</span></div>
                                                <div style='$style2' class='t'>payment_id: <span style='$style2'>$payment_id</span></div>
                                                <div style='$style2' class='t'>product id: <span style='$style2'>$product_id</span></div>
                                                <div style='$style2' class='t'>order_date: <span style='$style2'>$order_date</span></div>
                                            </div>
                                            
                                            <div class='t orderStatus'> 
                                                <form method='post'  style='$style2; font-size: 13px; margin-left: 8px;'>
                                                   order_status: <input type='text' name='order_status' class='in' value='$order_status'>
                                                    <input type='submit' class='inpBtn' name='submit'>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            ";
                        }
                    }
                } 
            ?>
        </div>
    </div>   
</body>
<script src="../main.js"></script>
</html>