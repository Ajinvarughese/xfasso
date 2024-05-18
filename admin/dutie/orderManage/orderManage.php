<?php 
session_start();
require_once '../../../connections/productdb.php';

if(empty($_SESSION['XQCLANG'])){
    header('Location: ../../admin-login/');
}

function showSuccess() {
    if(isset($_SESSION['showSuccess'])) {
        if($_SESSION['showSuccess'] == "happened") {
            echo "
                <script>
                let s = document.getElementById('s');
                s.innerHTML = 'product status updated successfully'
                s.style.color = 'green';
                setTimeout(()=> {
                    s.innerHTML = '';
                }, 4000);
                </script>
            ";
            $_SESSION['showSuccess'] = "";
        }else if($_SESSION['showSuccess'] == "notHappend") {
            echo "
                <script>
                let s = document.getElementById('s');
                s.innerHTML = 'something went wrong try again later.'
                s.style.color = 'red';
                setTimeout(()=> {
                    s.innerHTML = '';
                }, 4000);
                </script>
            ";
            $_SESSION['showSuccess'] = "";
        }
    }
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
            max-width: 720px;
            width: 99%;
            margin: 0 auto;
        }
        .omMain h1{
            font-size: x-large;
            width: fit-content;
        }

        #s {
            font-size: 13px;
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
            padding: 0.3rem 0;
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            justify-content: space-between;
            transition: 0.3s ease;
        }
        .card:hover {
            transform: scale(1.019);
            border: 1px solid #121b12df;
        }
        .cardImg {
            padding: 4px;
            max-width: 100px;
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
            display: flex;
            align-items: center;
        }
        .inpBtn {
            padding: 2.6px 8px;
            cursor: pointer;
        }
        .in {
            font-weight: 600;
            font-size: 15px;
            padding: 2px;
            margin: 5px 4px;
            width: 54px;
            text-align: center;
        }
        .vals {
            display: none;
        }
        .warn {
            font-size: 13px;
            color: red;
        }
        .search-container {
            margin-top: 1rem;
        }
        .search-input {
            padding: 0.5rem;
            font-size: 14px;
            width: 100%;
            max-width: 600px;
        }
        .search-button {
            padding: 0.5rem;
            font-size: 14px;
            cursor: pointer;
        }
        .no-results {

            display: none;
            margin: 0 auto;
            max-width: 260px;
            text-align: center;
            margin-top: 20px;
        }
        .no-results img {
            max-width: 100%;
            height: auto;
        }
        .hidden {
            visibility: hidden;
        }
    </style>    
    <div class="omMain">
        <h1>Current orders
            <hr>
        </h1>
        <p id="s"></p>
        <?php 
            showSuccess();
        ?>
        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Search by Order ID, Product ID or Username">
        </div>
        <div class="prodCard" id="order-cards">
            
            
            <div class="no-results" id="no-results">
                <img src="../../images/nothing.jpg" alt="No results found">
                <p>No matching orders found.</p>
            </div>

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

                        $seven_days_ago = date('Y-m-d H:i:s', strtotime('-7 days'));

                        $orderPHPobj = json_decode($res['order_json'], true);

                        $username = $orderPHPobj['user']['user_address']['fullName'];
                        $user_id = $orderPHPobj['user']['user_id'];
                        $order_id = $res['order_id'];
                        $payment_id = $orderPHPobj['payment']['payment_id'];
                        $order_status = $res['order_status'];
                        $order_date = $orderPHPobj['payment']['date'];

                        for($i=0; $i<count($orderPHPobj['products']); $i++) {
                            if($order_date <= $seven_days_ago && $order_status == 3) {
                                continue;
                            }else {
                                $product_id = $orderPHPobj['products'][$i]['product_id'];
                                echo "
                                    <p class='warn'></p>
                                    <div style='$style1' class='card'>
                                        <div class='cardImg'>
                                            <img src='../../../download.jpeg' alt='product image'>
                                        </div>
                                        <div class='contas'>
                                            <div class='cont'>
                                                <div style='$style2' class='t'>username: <span style='$style2' class='username'>$username</span></div>
                                                <div style='$style2' class='t'>user id: <span style='$style2'>$user_id</span></div>
                                                <div style='$style2' class='t'>order_id: <span style='$style2' class='order_id'>$order_id</span></div>
                                                <div style='$style2' class='t'>payment_id: <span style='$style2'>$payment_id</span></div>
                                                <div style='$style2' class='t'>product id: <span style='$style2' class='product_id'>$product_id</span></div>
                                                <div style='$style2' class='t'>order_date: <span style='$style2'>$order_date</span></div>
                                            </div>
                                            
                                            <div class='t orderStatus'> 
                                                <form method='post' action='editOrder.php' id='form' onsubmit='return handleForm()'  style='$style2; font-size: 13px; margin-left: 8px;'>
                                                    <input class='vals' name='order_id' value='$order_id'>
                                                    <input class='vals' name='user_id' value='$user_id'>
                                                    <input class='vals' name='product_id' value='$product_id'>
                                                    order_status: <input type='text' name='order_status' class='in' value='$order_status'>
                                                    <input type='submit' class='inpBtn' name='submit'>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                ";
                            }
                        }
                    }
                } 
            ?>
        </div>
    </div>   
</body>
<script>
let form = document.getElementById('form');
let inp = document.getElementsByClassName("in");
let w =document.getElementsByClassName('warn');

for(let i=0; i<inp.length; i++) {
    inp[i].addEventListener('input', ()=> {
        w[i].innerHTML = '';
    })
}

function handleForm() {
    let inp = document.getElementsByClassName("in");
    let w =document.getElementsByClassName('warn');
    for(let i=0; i<inp.length; i++) {
        if(inp[i].value === "") {
            w[i].innerHTML = 'please give a valid input';
            return false;
        }
    }
    return true;
}

document.getElementById('search-input').addEventListener('input', function() {
    let filter = document.getElementById('search-input').value.toUpperCase();
    let cards = document.getElementById('order-cards').getElementsByClassName('card');
    let noResults = document.getElementById('no-results');
    let matches = 0;
    
    for (let i = 0; i < cards.length; i++) {
        let order_id = cards[i].getElementsByClassName('order_id')[0].textContent;
        let product_id = cards[i].getElementsByClassName('product_id')[0].textContent;
        let username = cards[i].getElementsByClassName('username')[0].textContent;
        
        if (order_id.toUpperCase().indexOf(filter) > -1 || 
            product_id.toUpperCase().indexOf(filter) > -1 || 
            username.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
            matches++;
        } else {
            cards[i].style.display = "none";
        }
    }
    if(matches === 0) {
        noResults.style.display = "block";
    } else {
        noResults.style.display = "none";
    }
});

</script>
<script src="../main.js"></script>
</html>
