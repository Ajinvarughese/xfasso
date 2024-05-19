<?php 
    session_start();
    require('../connections/productdb.php');
    require_once '../checkexistence/checkExistence.php';

    if(isset($_COOKIE['XassureUser'])) {
        $emailId = mysqli_escape_string($conn, $_COOKIE['XassureUser']);
        $cookiePassword = mysqli_escape_string($conn, $_COOKIE['X9wsWsw32']);

        if(checkUserExistence($conn, $emailId, $cookiePassword) == false) {
            header('Location: ../signup/signup.html');
        }

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
            header('Location: ../signup/signup.html');
        }

    }else {
        header('Location: ../signup/signup.html');
    }

    if(isset($_COOKIE['product'])) {

        $pId = $_COOKIE['product'];

        $ciphering = "AES-128-CTR";
        $options = 0;
        $decryption_iv = '1234567891021957';
        $decryption_key = "xfassoKey";
        $decrypted_id = openssl_decrypt($pId, $ciphering, $decryption_key, $options, $decryption_iv);
        $pRId = $decrypted_id;

        $q = "DELETE FROM cart_user WHERE SI_NO='$pRId'";
        mysqli_query($conn, $q);
        setcookie("product", "", time()-0,"/");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/details.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       




    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My cart</title>
</head>
<body>
    <div class="navCart">
        <div class="logo">
            <div style="cursor: pointer;" id="_f3fs" class="nav-logo primary">
                XFASSO
            </div>
            <script>
                document.getElementById('_f3fs').addEventListener('click', ()=> {
                    window.location.href = '../';
                })
            </script>
        </div>
    </div>
    <div class="mainCart">
        
        <div class="cards-container-cart">
            <?php 
                $total = 0;
                $numberOfItem = 0;
                $cartQ = "SELECT *FROM cart_user WHERE user_id = '$user_id'";
                $cart = mysqli_query($conn, $cartQ);
                if(mysqli_num_rows($cart) > 0) {
                    $emptyCart = false;
                    $newQuery = "SELECT * FROM cart_user WHERE user_id = '$user_id'";
                    while($rowCart = mysqli_fetch_assoc($cart)) {
                        $newRun = mysqli_query($conn, $newQuery);
                        $resNew = mysqli_fetch_assoc($newRun);

                        $prodId = $rowCart['cart_product'];
                        $getDetQ = "SELECT * FROM products WHERE product_id = '$prodId' AND stock_status = 1";
                        $resGetD = mysqli_query($conn, $getDetQ);
                        
                        if(mysqli_num_rows($resGetD)>0) {
                            $rowGetD = mysqli_fetch_assoc($resGetD);

                            $SI_NO = $rowCart['SI_NO'];
                            // encryption of product ID
                            $productId = "productIdOfXfassoYes $prodId";
                            //encrypting
                            $ciphering = "AES-128-CTR";
                            $iv_length = openssl_cipher_iv_length($ciphering);
                            $options = 0;
                            $encryption_iv = '1234567891021957';
                            $encryption_key = "xfassoKey";
                            $encryptedProduct = openssl_encrypt($productId, $ciphering, $encryption_key, $options, $encryption_iv);

                            $encryptedSI_NO = openssl_encrypt($SI_NO, $ciphering, $encryption_key, $options, $encryption_iv);

                            $cartPrice = $rowGetD['product_price'] * $rowCart['quantity'];

                            $imageCart = base64_encode($rowGetD['product_image']);
                            $imageTypeCart = "image/jpeg";

                            echo "
                                <div class='iaj'>
                                    <a href='../details/details.php?productId={$encryptedProduct}'>
                                        <div class='productImg' id='{$encryptedProduct}'>
                                            <img src='data:$imageTypeCart;base64,$imageCart' alt='product image'>
                                        </div>
                                    </a>
                                    <div class='desc'>
                                        <div class='title-dlt'>
                                            <a style='text-decoration: none;' href='../details/details.php?productId={$encryptedProduct}'>
                                                <h1>{$rowGetD['product_name']}</h1>
                                            </a>
                                            <div class='dlt' onclick='dlt{$numberOfItem}()'>
                                                <i class='fa fa-trash-o fa-lg' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                        <div class='contents'>
                                            <div class='size'>
                                                size: {$rowCart['size']}
                                            </div>
                                            <div class='quantity'>
                                                Quantity: {$rowCart['quantity']}
                                            </div>
                                            <div class='price'>
                                                ₹{$cartPrice}
                                            </div>
                                            <div class='delType'>
                                                Delivery Type: <span>Free Delivery</span>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                        
                                        function dlt{$numberOfItem}(){
                                            var cookieExpires = new Date(Date.now() + (24 * 60 * 60 * 1000)).toUTCString();
                                            document.cookie = 'product={$encryptedSI_NO}; expires='+ cookieExpires +'; path=/';
                                            window.location.reload();
                                        }
                                    </script>
                                </div>
                            ";
                            $numberOfItem += 1;

                            $total += $rowGetD['product_price'];
                        }
                    }
                }else {
                    echo "
                        <div class='msgMain'>
                            <div class='im'>
                                <img src='../resources/empty-cart.png'> 
                            </div>
                            <div class='msg'>Your cart is empty</div>
                            <a href='../shop/shop.php'>Shop Now</a>
                        </div>
                    ";
                    $emptyCart = true;
                }
                    ?>
            <div <?php echo $emptyCart? 'style=display:none;': 'style=display:block;'?> id="total" class="total">
                <div class="_j2k3">
                    <hr>
                    <div style="margin: 18px 0;" class="t item-total">
                        <div class="title">
                            Price Details
                        </div>
                        <div class="_o1">
                            <div class="_p23">
                                Price (<?php echo $numberOfItem, $numberOfItem>1?' items':' item';?>)
                            </div>
                            <?php 
                                $cartQT = "SELECT * FROM cart_user WHERE user_id = '$user_id'";
                                $cartT = mysqli_query($conn, $cartQT);
                                if(mysqli_num_rows($cartT) > 0) {
                                    while($rowT = mysqli_fetch_assoc($cartT)) {
                                        $prodT_id = $rowT['cart_product'];
                                        $getDetQT = "SELECT product_price FROM products WHERE product_id='$prodT_id' AND stock_status = 1";
                                        $resGetDT = mysqli_query($conn, $getDetQT);  

                                        if(mysqli_num_rows($resGetDT)>0) {
                                            $rowGetDT = mysqli_fetch_assoc($resGetDT);
                                            $showPrice = $rowGetDT['product_price'];
                                            $eachPrice = $rowGetDT['product_price']* $rowT['quantity'];
                                            echo 
                                            "   <div class='_ip'>
                                                    ₹{$showPrice} ({$rowT['quantity']})
                                                </div>
                                            ";
                                            $total -= $rowGetDT['product_price'];
                                            $total +=$eachPrice;
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div style="margin: 18px 0;" class="t del">
                        <div class="del2">
                            Delivery Charges
                        </div>
                        <div class="del3">
                            FREE Delivery
                        </div>
                    </div>
                    <hr>
                    <div style="margin: 18px 0;" class="t price-total">
                        <div class="_u21">
                            Total Amount
                        </div>
                        <div class="_ij1">
                            ₹<?php echo $total?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div <?php echo $emptyCart? 'style=display:none;': 'style=display:block;'?> id="buy" class="buy">
            <div class="_i21ns">
                <div class="price-nav" style='font-weight: 700; font-size: 17px;'>
                    ₹<?php echo $total?>
                </div>
                <div class="_a"></div>
                <div class="_a921n"></div>
                <form class="price-button" method="post">
                    <input type="submit" name="placeOrder" value="Place Order">
                </form>
                <?php 
                    if(isset($_POST['placeOrder'])) {
                        
                        $_SESSION['setCart'] = true;
                        $_SESSION['newCheckoutProduct'] = false;
                        echo "<script>window.location.href = '../checkout/checkout.php'</script>";
                    }
                ?>
            </div>
            <div class="order-now">
               <p>Order Now with XFASSO</p>
            </div>
        </div>

        <div class="moreYouLike" style="margin-top: 2rem;">
            <style>
                ._p1 {
                    padding: 1rem;
                }
                .more {
                    display: flex;
                    overflow: auto hidden;
                    align-items: center;
                    gap: 1.2rem;
                    padding-bottom: 1rem;
                    justify-content: flex-start;
                
                }
                .card-more {
                    border: 1px solid #d2d5d9;
                    flex-grow: calc(2rem);
                    min-width: 186px;
                    max-width: 330px;
                    max-height: 310px;
                    min-height: 280px;
                }
                .img-more {
                    height: 180px;
                }
                .img-more img {
                    max-width: 100%;
                    max-height: 100%;
                    display: block;
                }
                .more::-webkit-scrollbar {
                    height: 7px;
                }
                .more::-webkit-scrollbar-thumb {
                    background: #12263a; 
                    border-radius: 20px;
                    visibility: visible;
                }
            </style>
            <div class="_p1">
                <h2 style="color: #12263a;">More you would like</h2>
                <br>
                <div class="more">

                    <?php 
                        $moreSqlQuery = "SELECT * FROM products WHERE stock_status = 1 ORDER BY RAND()";
                        $moreSqlResult = mysqli_query($conn, $moreSqlQuery);

                        if(mysqli_num_rows($moreSqlResult)>0) {
                            function isInteger($value) {
                                return is_numeric($value) && intval($value) == $value;
                            }
                            while($more = mysqli_fetch_assoc($moreSqlResult)) {
                                $averageStarCount = $more['avg_star'];
                                $productId = "productIdOfXfassoYes {$more['product_id']}";

                                if($more['stock_status'] != 0) {
                                    //encrypting
                            
                                    $ciphering = "AES-128-CTR";
                                    $iv_length = openssl_cipher_iv_length($ciphering);
                                    $options = 0;
                                    $encryption_iv = '1234567891021957';
                                    $encryption_key = "xfassoKey";
                                    $encrypted_id = openssl_encrypt($productId, $ciphering, $encryption_key, $options, $encryption_iv);


                                    $imageMore = base64_encode($more['product_image']);
                                    $imageTypeMore = "image/jpeg";
                                    echo "
                                        <a href='../details/details.php?productId={$encrypted_id}' style='color: inherit; text-decoration: none;'>
                                            <div class='card-more'>
                                                <div class='img-more'>
                                                    <img src='data:$imageTypeMore;base64,$imageMore' alt='>
                                                </div>
                                                <div class='content-more'>
                                                    <div style='padding: 5px 10px;' class='title'>{$more['product_name']}</div>
                                                    <div style='padding: 0px 10px;'>
                                                        <p class='secondary rate'>"; 
                                                        if($averageStarCount > 0) {
                                                            if(isInteger($averageStarCount)) {
                                                                for($k=0; $k<$averageStarCount; $k++) {
                                                                    echo "<span><img src='../resources/icons8-star-50.png' class='star'></span>";
                                                                }
                                                                for($k=0; $k<5-$averageStarCount; $k++) {
                                                                    echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                                                }
                                                            }else {
                                                                for($k=0; $k<$averageStarCount-1; $k++) {
                                                                    echo "<span><img src='../resources/icons8-star-50.png' class='star'></span>";
                                                                }
                                                                echo "<span><img src='../resources/icons8-star-half-empty-50.png' class='star'></span>";
                                                                for($k=0; $k<5-$averageStarCount-1; $k++) {
                                                                    echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                                                }
                                                            }
                                                            echo "&nbsp;{$averageStarCount}";
                                                        }else {
                                                            for($k=0; $k<5; $k++) {
                                                                echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                                            }
                                                        }
                                                        echo "</p> 
                                                    </div>
                                                    <div style='padding:0 10px 5px 10px; font-size: 14px;' class='price'>₹{$more['product_price']}</div>
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
            <br>
            <br>
            <br>
            <div id="email-us" class="email-us">
                <h1 class="primary">Email Us.</h1>
                <form action="../connections/mailto.php" method="post">
                    <input type="text" class="_i044d" name="email-text" value="" required placeholder="Your suggetions goes here">
                    <input type="submit" name="submit" onclick="emailSubmit()" id="email-submit">
                    <label for="email-submit" class="btn-email">
                        <img src="../resources/icons8-arrow.gif" alt="->">
                    </label>
                    <p id="emailSending" class="emailSending secondary"></p>
                </form>
                <p class="_c45 secondary">&copy; xfasso 2024</p>
            </div>
        </div>
    </div>
    <script>
        var emailSending = document.getElementById('emailSending');
        function emailSubmit() {
            emailSending.textContent = 'Sending email...'
            emailSending.style.display = 'block';
        }
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        if(getCookie('message-sent')) {
            emailSending.style.display = 'block';
            emailSending.textContent = 'email send succesfully...';
            setTimeout(()=> {
                emailSending.style.display = 'none';
                document.cookie = 'message-sent=messageSentTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/';
            }, 4000)
        }
    </script>
</body>
</html>





<?php 
    mysqli_close($conn);
?>