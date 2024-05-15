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

            if(isset($_SESSION['newCheckoutProduct'])) {
                $checkoutProduct = $_SESSION['newCheckoutProduct'];
            }else {
                $isSetCartQ = "SELECT * FROM cart_user WHERE user_id = '$user_id'";
                $resCart = mysqli_query($conn, $isSetCartQ);

                if(mysqli_num_rows($resCart)>0) {
                    $_SESSION['setCart'] = true;
                    $_SESSION['newCheckoutProduct'] = false;
                }else {
                    header('Location: ../shop/shop.php');
                }
            }
        }

    }else {
        header('Location: ../signup/signup.html');
    }

    if(isset($_COOKIE['quantity'])) {
        if($_COOKIE['quantity']>5) {
            setcookie('quantity', 5, time()+3600*24, '/');
            echo "<script>window.location.reload()</script>";
        }
        $quantityBuyNow = $_COOKIE['quantity'];
    }

    if(isset($_COOKIE['Xz-6fg4j'])) {
        $sizeBuyNow = $_COOKIE['Xz-6fg4j'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Product</title>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       
    
    
    <link rel="stylesheet" href="../css/checkout.css">


</head>
<body>
    <div class="nav">
        <img id="jkwnff" src="../resources/left-arrow.png" width="32px">
    </div>
    <script>
        document.getElementById('jkwnff').addEventListener('click', ()=> {
            window.location.href = '../cart/cart.php';
        })
    </script>
    <div class="_askjd">
        <div class="mainOrder">

            
            <div class="form1" id="loginForm">
                <div class="formHead">
                    <div class="hq">
                        <div class="hqi">
                            <div class="h"><span>1</span> LOGIN</div>
                            <div class="f"><img src="../resources/icons8-tick-48.png" alt="checked" width="22px"></div>
                        </div>
                        <button id="changeUser" class='changeUser'>Change</button>
                    </div>
                    <div class="contentHead">
                        <?php 
                            $qTitle = "SELECT * FROM users WHERE email='$email'";
                            $res = mysqli_query($conn, $qTitle);
                            if(mysqli_num_rows($res) > 0) {
                                $row = mysqli_fetch_array($res);
                                $username = $row['username'];
                            }
                            echo "<div id='akdn' class='zffqg'>$username</div>
                                  <div id='akd' class='zffqg'>$email</div>
                            ";
                        ?>
                    </div>
                </div>
                <div id="formContent" style="display: none;" class="formContent">
                    <p>Are you sure you want to log out and sign in again?</p>
                    <div class="a9kjw">
                        <?php 
                            echo "
                                <p>$username</p>
                                <p>$email</p>
                            ";
                        ?>
                        <button id="logOutAcc">Change account</button>
                    </div>
                   
                    <script>
                        var changeUser =document.getElementById('changeUser');
                        var formContent =document.getElementById('formContent');
                        var akdn =document.getElementById('akdn');
                        var akd =document.getElementById('akd');

                        changeUser.addEventListener('click', ()=> {
                            
                            if(formContent.style.display == 'block'){
                                formContent.style.display = 'none';
                                changeUser.textContent = 'Change';
                                akdn.style.display = 'block';
                                akd.style.display = 'block';
                            }else {
                                formContent.style.display = 'block';
                                changeUser.textContent = 'Save';
                                akdn.style.display = 'none';
                                akd.style.display = 'none';
                            }
                        })


                        var logOutAcc =document.getElementById('logOutAcc');
                        logOutAcc.addEventListener('click', ()=> {
                            document.cookie = "XassureUser=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
                            window.location.href='../login/login.php';
                        })
                    </script>
                </div>
            </div>








            <div class="form1" id="form2">
                <div class="formHead">
                    <div class="hq">
                        <div class="hqi">
                            <div class="h"><span>2</span> DELIVERY ADDRESS</div>
                            <div class="f"><img id="tick" src="../resources/icons8-tick-48.png" alt="checked" width="22px"></div>
                        </div>
                        <button style='padding:0; height: 38px; width: 124px;' class='changeUser' id='changeUserP2' onclick='aAdd()'>Edit address</button>
                    </div>
                    <div class="contentHead" id="contentHead">
                        <?php 
                            $sqlAdd = "SELECT * FROM users WHERE email='$email'";
                            $runAdd = mysqli_query($conn, $sqlAdd);
                            if(mysqli_num_rows($runAdd)>0) {
                                $resAdd = mysqli_fetch_assoc($runAdd);
                                if($resAdd['address']) {
                                
                                    $addData = json_decode($resAdd['address']);
                                    
                                    $_SESSION['user'] = array(
                                        "user_id" => $resAdd['user_id'],
                                        "user_name" => $resAdd['username'],
                                        "email" => $resAdd['email'],
                                        "user_address" => $addData
                                    );

                                    print

                                    $name = $addData->fullName;
                                    $mob = $addData->phone;
                                    $mob2 = $addData->altPhone;
                                    $pinCode = $addData->pinCode;
                                    $state = $addData->state;
                                    $city = $addData->city;
                                    $address = $addData->address;
                                    $place = $addData->place;
                                    $landmark = $addData->landmark;

                                    $textCo = $mob2? "$name &nbsp; $mob / $mob2": "$name &nbsp; $mob"; 
                                    echo "<div id='addr'>$textCo</div>";
                                    $nullAdd = false;
                                }else {
                                    $nullAdd = true;
                                    $textCo = "";
                                    $address = "";
                                    $landmark = "";
                                    $city = "";
                                    $state ="";
                                    $pinCode ="";
                                    echo "
                                        <script>
                                            var tick = document.getElementById('tick');
                                            tick.src='../resources/multiply.png';
                                        </script>
                                    ";
                                }
                            }
                        ?>
                        
                    </div>
                            
                    <script>
                        function aAdd() {
                            window.location.href = '../profile/u/myaddress.php';
                        }
                    </script>

                    <button id="changeUserP" class='changeUser'></button>
                </div>

                <div class="formContent" id="formContentP">
                    <div class="addCard">
                        <div class="namePhone"><p>
                            <?php
                                echo "<div id='akom'>$textCo</div>"; 
                            ?>
                            </p>
                        </div>
                        <div class="address">
                            <p>
                                <?php 
                                    if($nullAdd) {
                                        echo "
                                            <script>
                                                var formContentP =document.getElementById('formContentP');
                                                formContentP.style.display = 'none';
                                            </script>
                                        ";
                                    }else {
                                        echo "
                                            
                                            $address, $landmark, $city, $state-<span style='font-weight:700;'>$pinCode</span>
                                        ";
                                    }
                                ?>
                            </p>
                            <form action="" method="post">
                                <br>
                                <input type="submit" name='isAddr' class='changeUser'>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    var formContentP =document.getElementById('formContentP');
                    var changeUserP =document.getElementById('changeUserP');

                    changeUserP.addEventListener('click', ()=> {

                        if(formContentP.style.display === 'none') {
                            formContentP.style.display = 'block';       
                            document.getElementById('addr').style.display = 'none'
                        }else {
                            formContentP.style.display = 'none';
                            document.getElementById('addr').style.display = 'block';
                        }

                    })
                </script>
            </div>
            

            <div class="form1" id="orderSummary">
                <div class="formHead" id="ain2In2">
                    <div class="hq">
                    <div class="h"><span>3</span> ORDER SUMMARY</div>
                    </div>
                    <div class="content" style="margin-top: 10px;">
                    <?php 
                        if(isset($_POST['isAddr'])) {
                            $_SESSION['isAddr'] = true;
                            $totalPrice = 0;
                            echo "
                                <script>
                                    var formContent = document.getElementById('formContentP');
                                    var contentHead = document.getElementById('contentHead');
                                    var form2 =document.getElementById('form2');

                                    var loginForm =document.getElementById('loginForm');

                                    form2.innerHTML = `
                                        <div class='hqi'>
                                            <div class='h'><span>2</span> DELIVERY ADDRESS</div>
                                            <div class='f'><img id='tick' src='../resources/icons8-tick-48.png' alt='checked' width='22px'></div>
                                        </div>
                                    `;
                                    loginForm.innerHTML = `
                                        <div class='hqi'>
                                            <div class='h'><span>1</span> LOGIN</div>
                                            <div class='f'><img src='../resources/icons8-tick-48.png' alt='checked' width='22px'></div>
                                        </div>
                                    `;


                                    while (formContent.firstChild) {
                                        formContent.removeChild(formContent.firstChild);
                                    }
                                    while (contentHead.firstChild) {
                                        contentHead.removeChild(contentHead.firstChild);
                                    }
                                </script>
                            ";
                            
                            if($_SESSION['newCheckoutProduct']) {
                                $_SESSION['setCart'] = false;

                                // to check user did buy now or add to cart
                                $_SESSION['sProduct'] = true;
                                $_SESSION['mProduct'] = false;
                            
                                $detailsQ = "SELECT * FROM products WHERE product_id='$checkoutProduct' AND stock_status = 1";
                                $detailsR = mysqli_query($conn, $detailsQ);
                        
                                if(mysqli_num_rows($detailsR)>0) {
                                    $detailsRow = mysqli_fetch_assoc($detailsR);

                                    $priceProduct = $detailsRow['product_price'];
                                    $totalPrice = $priceProduct * $quantityBuyNow;

                                    $_SESSION['price'] = $totalPrice;

                                    $imageBuyNow = base64_encode($detailsRow['product_image']);
                                    $imageTypeBuyNow = "image/jpeg";
                                    
                                    echo "
                                        <div class='pCard'>
                                            <div class='prdImg'>
                                                <img src='data: $imageTypeBuyNow;base64,$imageBuyNow' alt='product image' width='123px'>
                                            </div>
                                            <div class='con'>
                                                <div class='ainw'>
                                                    <div class='t'>
                                                    <h3>{$detailsRow['product_name']}</h3>
                                                    </div>
                                                    <div class='siz'>
                                                        size $sizeBuyNow
                                                    </div>
                                                    <div class='quantity'>
                                                        quantity: $quantityBuyNow
                                                    </div>
                                                    <div class='price'>
                                                        ₹$totalPrice
                                                    </div>
                                                </div>
                                                <div class='delType'>
                                                    Delivery Type: <span>Free Delivery</span>
                                                </div>
                                            </div>
                                        </div> 
                                    ";

                                    $_SESSION['products'] = array(
                                        array(
                                            "product_id" => $checkoutProduct,
                                            "product_name" => $detailsRow['product_name'],
                                            "product_price" => $totalPrice,
                                            "quantity" => $quantityBuyNow,
                                            "size" => $sizeBuyNow
                                        )
                                    );
                                }else {
                                    echo 
                                    "
                                        <script>
                                            window.location.href ='../';
                                        </script>
                                    ";
                                }
                            }elseif($_SESSION['setCart']) {

                                // to check user ordered via add to cart or buy now
                                $_SESSION['sProduct'] = false;
                                $_SESSION['mProduct'] = true;


                                $totalPrice = 0;
                                $cartUQ = "SELECT * FROM cart_user WHERE user_id='$user_id'";
                                $cartUR = mysqli_query($conn, $cartUQ);

                                $i = 0;
                                $_SESSION['user'];
                                $_SESSION['products'] = array();
                                while($resCart = mysqli_fetch_assoc($cartUR)) {
                                    $pIdCart = $resCart['cart_product'];
                                    $getPQ = "SELECT * FROM products WHERE product_id='$pIdCart' AND stock_status = 1";
                                    $getPR = mysqli_query($conn, $getPQ);

                                    if(mysqli_num_rows($getPR)>0) {
                                        
                                        $pRow = mysqli_fetch_assoc($getPR);

                                        $quantityProduct = $resCart['quantity'];
                                        $priceProduct = $pRow['product_price'];
                                        $priceByQua = $priceProduct * $quantityProduct;

                                        $imageCheckout = base64_encode($pRow['product_image']);
                                        $imageTypeChekcout = "image/jpeg";
                                        
                                        
                                        echo "
                                        <div class='pCard'>
                                            <div class='prdImg'>
                                                <img src='data:$imageTypeChekcout;base64,$imageCheckout' alt='product image' width='123px'>
                                            </div>
                                            <div class='con'>
                                                <div class='ainw'>
                                                    <div class='t'>
                                                    <h3>{$pRow['product_name']}</h3>
                                                    </div>
                                                    <div class='siz'>
                                                        size {$resCart['size']}
                                                    </div>
                                                    <div class='quantity'>
                                                        quantity: $quantityProduct
                                                    </div>
                                                    <div class='price'>
                                                        ₹$priceByQua
                                                    </div>
                                                </div>
                                                <div class='delType'>
                                                    Delivery Type: <span>Free Delivery</span>
                                                </div>
                                            </div>
                                        </div>
                                        ";
                                        $totalPrice += $priceByQua;
                                        $_SESSION['price'] = $totalPrice;
                                        $i++;

                                        $detailsJSON = array(
                                            "product_id" => $pIdCart,
                                            "product_name" => $pRow['product_name'],
                                            "product_price" => $priceProduct,
                                            "quantity" => $quantityProduct,
                                            "size" => $resCart['size']
                                        );
                                        $_SESSION['products'][] = $detailsJSON;
                                    }
                                }
                                $_SESSION['setCart'] = false;
                                if($i == 0) {
                                    echo 
                                    "
                                        <script>
                                            window.location.href ='../';
                                        </script>
                                    ";
                                }
                            }else {
                                echo 
                                    "
                                        <script>
                                            window.location.href ='../';
                                        </script>
                                    ";
                            }

                        }else {
                           
                            $_SESSION['isAddr'] = false;

                        }

                        


                    ?>
                    </div>

                    <div class="i3na">
                        <div class="ajwkq">
                            TOTAL
                        </div>
                        <div class="qina">
                            ₹<?php echo isset($_SESSION['isAddr'])? $totalPrice : 0 ?>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <br>
                    <input type="submit" name='isOrder' class='changeUser'>
                </form>
                <?php 
                    if(empty($_SESSION['isAddr'])) {
                        echo "
                            <script>
                                var orderSummary = document.getElementById('orderSummary');
                                var orderS = document.getElementById('ain2In2');

                                orderSummary.innerHTML = `
                                    <div class='hqi'>
                                        <div class='h'><span>3</span> ORDER SUMMARY</div>
                                    </div>
                                `;
                                while (orderS.firstChild) {
                                    orderS.removeChild(orderS.firstChild);
                                }
                            </script>
                        ";
                    }
                ?>

            </div>

            <!-- PAYMENT -->

            <div class="form1" id="payment">
                <div style="margin-bottom: 1.6rem;" class="formHead">
                    <div class="hq">
                        <div class="hqi">
                            <div class="h"><span>4</span>PAYMENT</div>
                        </div>
                    </div>

                </div>
                <form class="content" method="post" action="../connections/paymentGate.php" style="margin-top: 10px;">
                    <input type="radio" checked name="UPIpay" id="aojwu2">
                    <input type="radio" name="NETpay" id="aob3wu">

                    <div class="aisbw">
                        <label for="aojwu2">
                            <div id="awjb" class="awjb">
                                <img src="../resources/upi.png" id="aoj" alt="upi" width="34px"><h3>UPI</h3>
                            </div>
                        </label>
                        <label for="aob3wu" >
                            <div id="aiwn" class="aiwn">
                                <img src="../resources/bank.png" id="aob" alt="netbank" width="34px"><h3>NET BANKING</h3>
                            </div>
                            <p id="warn" style="color: red; font-size: 12px;"></p>
                        </label>
                    </div>
                    <input type="submit" id="conPa" value="Continue" class="changeUser" style="margin-top: 0.8rem;">
                    <script>
                        var aojwu2 =document.getElementById('aojwu2');
                        var aob3wu =document.getElementById('aob3wu');
                        
                        var upi = document.getElementById('awjb');
                        var netbank =document.getElementById('aiwn');

                        var confirmPa =document.getElementById('conPa');

                        aojwu2.addEventListener('click', ()=> {
                            if(aojwu2.checked) {
                                confirmPa.disabled = false;
                                confirmPa.style.opacity = '1';
                                confirmPa.style.cursor = 'pointer';
                                document.getElementById('warn').innerHTML = '';


                                aob3wu.checked = false;
                                upi.style.border = "3px solid";
                                netbank.style.border = 'none';

                                upi.style.opacity = '1';
                                netbank.style.opacity = '0.5';
                            }else {
                                aob3wu.checked = true;
                                upi.style.border= "none";

                                upi.style.opacity = '0.5';
                                netbank.style.opacity = '1';
                            }
                        })
                        aob3wu.addEventListener('click', ()=> {
                            if(aob3wu.checked) {
                                confirmPa.disabled = true;
                                confirmPa.style.opacity = '0.3';
                                confirmPa.style.cursor = 'not-allowed';
                                document.getElementById('warn').innerHTML = 'currently not available.';

                                netbank.style.border = "3px solid";
                                upi.style.border = "none";
                                aojwu2.checked = false;

                                upi.style.opacity = '0.5';
                                netbank.style.opacity = '1';
                            }else {

                                netbank.style.border = "none";
                                aojw2.checked = true;

                                upi.style.opacity = '1';
                                netbank.style.opacity = '0.5';
                            }
                        })
                    </script>                    
                </form>
                <?php 
                    if(isset($_POST['isOrder'])) {
                        $totalPrice = $_SESSION['price'];

                        if($totalPrice == 0.0 || $totalPrice == 0) {
                            echo "
                                <script>
                                    window.location.href = '../';
                                </script>
                            "; // solve this issue no $totalPrice foundd!
                        }
                        $_SESSION['isAdd'] = true;
                        
                        echo "
                            <script>
                                var formContent = document.getElementById('formContentP');
                                var contentHead = document.getElementById('contentHead');
                                var form2 = document.getElementById('form2');

                                var loginForm = document.getElementById('loginForm');


                                var orderSummary = document.getElementById('orderSummary');

                                orderSummary.innerHTML = `
                                    <div class='hqi'>
                                        <div class='h'><span>3</span> ORDER SUMMARY</div>
                                         <div class='f'><img id='tick' src='../resources/icons8-tick-48.png' alt='checked' width='22px'></div>
                                    </div>
                                `;

                                form2.innerHTML = `
                                    <div class='hqi'>
                                        <div class='h'><span>2</span> DELIVERY ADDRESS</div>
                                        <div class='f'><img id='tick' src='../resources/icons8-tick-48.png' alt='checked' width='22px'></div>
                                    </div>
                                `;
                                loginForm.innerHTML = `
                                    <div class='hqi'>
                                        <div class='h'><span>1</span> LOGIN</div>
                                        <div class='f'><img src='../resources/icons8-tick-48.png' alt='checked' width='22px'></div>
                                    </div>
                                `;

                                while (formContent.firstChild) {
                                    formContent.removeChild(formContent.firstChild);
                                }
                                while (contentHead.firstChild) {
                                    contentHead.removeChild(contentHead.firstChild);
                                }
                            </script>
                        ";
                    }else {
                        echo "
                            <script>
                                var payment = document.getElementById('payment');
                                while(payment.firstChild) {
                                    payment.removeChild(payment.firstChild);
                                }
                                payment.innerHTML = `
                                    <div class='hqi'>
                                        <div class='h'><span>4</span>PAYMENT</div>
                                    </div>
                                `;
                            </script>
                        ";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
