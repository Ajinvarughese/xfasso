<?php 
    require '../../../../connections/productdb.php';
    require_once '../../../../checkexistence/checkExistence.php';
    session_start();

    $isDelivered = false;

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
            
            $orderId = mysqli_escape_string($conn, $decrypted_id);
            $decrypted_id = mysqli_escape_string($conn, $decrypted_id);
            
            $quer = "SELECT * FROM orders WHERE order_id ={$orderID} AND user_id='{$user_id}'";
            $runQ = mysqli_query($conn, $quer);
            if(mysqli_num_rows($runQ)>0) {

                //for rating product
                $_SESSION['USER_ID_ORDERDETAILS'] = $user_id;
                $_SESSION['PRODUCT_ID_ORDERDETAILS'] = $decrypted_id;

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

                //Check delivery
                if($res['order_status'] == 3) {
                    $isDelivered = true;
                }
                
                //Top page
                $orderID = $phpObj['payment']['order_id'];
                $paymentID = $phpObj['payment']['payment_id'];
                $userDetails = $phpObj['user'];
                
                //Card page
                $prodName = $phpObj['products'][$i]['product_name'];
                $prodSize = $phpObj['products'][$i]['size'];
                $prodQuantity = $phpObj['products'][$i]['quantity'];
                $prodPrice = $phpObj['products'][$i]['product_price'];
                
                //Address page
                $userAddress = $phpObj['user']['user_address'];
                $fullName = $userAddress['fullName'];
                $phone = $userAddress['phone'];
                $altPhone = $userAddress['altPhone'];
                if($altPhone != "") {
                    $altPhone = ", ".$altPhone;
                }
                $address = $userAddress['address'];
                $pinCode = $userAddress['pinCode'];
                $state = $userAddress['state'];
                $city = $userAddress['city'];
                $place = $userAddress['place'];
                $landmark = $userAddress['landmark'];

                $addressContent = "
                    <p>{$fullName}</p>
                    <p>{$address} {$place}, $city $state $pinCode {$landmark}</p>
                    <p>{$phone}{$altPhone}</p>
                ";

                //Product Image
                $querProduct = "SELECT * FROM products WHERE product_id = {$decrypted_id}";
                $runProduct = mysqli_query($conn, $querProduct);

                if(mysqli_num_rows($runProduct)>0) {
                    $resProduct = mysqli_fetch_assoc($runProduct);
                    $imageData = base64_encode($resProduct['product_image']);
                    $imageType = "image/jpeg";


                    $orderRating = json_decode($resProduct['rating'], true);
                }else {
                    header("Location: ../../../../errors/errors.php?errorID=1001");
                }

                //Delivery
                $deliveryDate = date("F d", strtotime($res['delivery']));
                $orderDate = date("F d, Y", strtotime($res['date']));
                $orderDate2 = date("F d", strtotime($orderDate));

                //scale level
                $scale = $res['order_status'];
                switch($scale) {
                    case 1:
                        $scaleLevel = 7;
                        break;
                    case 2:
                        $scaleLevel = 57;
                        break;
                    case 3:
                        $scaleLevel = 100;
                        break;
                    default:
                        $scaleLevel = 0;
                }
                $updateStarcount = false;
                if(isset($_SESSION['UPDATE_STARCOUNT'])) {
                    if($_SESSION['UPDATE_STARCOUNT'] != false) {
                        $_SESSION['UPDATE_STARCOUNT'] = false;
                        $updateStarcount = true;
                    }
                }


                if(isset($orderRating)) {
                    for($i=0; $i<count($orderRating); $i++) {
                        if($orderRating[$i]["userID"] == $user_id) {
                            $starCount = $orderRating[$i]['starCount'];
                            $description = $orderRating[$i]['description'];
                            break;  
                        }
                    }
                }
                
            }else {
                header("Location: ../../../../errors/errors.php?errorID=404");
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

    
</head>
<body>
    <div class="nav">
        <div style="cursor: pointer;" onclick="user(false)" id="back" class="back">
            <img src="../../../../resources/left-arrow.png" width="32px">
        </div>
        <div onclick="{window.location.href='../../../../';}" class="logo">
            <h1>XFASSO</h1>
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
    
    <div class="main">
        <div class="imp">
            <p>order is made for <?php echo $userDetails['user_name'] ?></p>
            <p>ordered on <?php echo $orderDate?></p>
        </div>
        <div class="orderID">
            <span>order id: </span><p style="opacity: 0.8;"> &nbsp;<?php echo $orderID;?></p>
        </div>
        <div class="orderDetails">
            <div class="card">
                <div class="content">
                    <div class="tiasd"><?php echo $prodName ?></div>

                    <div class="ainw">
                        <div class="size"> <span>size: </span>  <?php echo $prodSize?></div>
                        <div class="quantity"><span>quantity: </span>  <?php echo $prodQuantity ?></div>
                        <div class="price"><span>price: </span> ₹<?php echo $prodPrice?></div>
                    </div>
                    
                </div>
                <?php 
                    $productId = "productIdOfXfassoYes {$decrypted_id}"; 
                    $ciphering = "AES-128-CTR";
                    $iv_length = openssl_cipher_iv_length($ciphering);
                    $options = 0;
                    $encryption_iv = '1234567891021957';
                    $encryption_key = "xfassoKey";
                    $encrypted_id = openssl_encrypt($productId, $ciphering, $encryption_key, $options, $encryption_iv);
                ?>
                <a class="apw" href="<?php echo "../../../../details/details.php?productId={$encrypted_id}";?>">
                    <div class="prodImg">
                        <?php echo "
                            <img src='data:$imageType;base64,$imageData' alt='{$prodName} image'>
                        "?>
                    </div> 
                </a>
            </div>


            <div class="del" id="del">
                <div class="date">
                    <div class="scale">
                        <div class="scaleOuter">
                            <div id="scale">
                            </div>
                        </div>

                        <div class="tkwn">
                            <div class="tick">
                                <img id="scale1">
                            </div>
                            <div class="tick">
                                <img id="scale2">
                            </div>
                            <div class="tick">
                                <img id="scale3">
                            </div>
                        </div>
                    </div>

                    <div class="dateForm">
                        <div class="orderDate">
                           <p>
                             order confirmed
                            <?php echo $orderDate2;?>
                           </p>
                        </div>
                        <div class="processing">
                           <p id="orderStatus">order processing</p>
                           <div id="orderTimer" class="timer">
                                <img src="../../../../resources/timer.gif" alt="">
                           </div>
                        </div>
                        <div class="expected">
                            <p>
                                expected delivery
                                <?php echo $deliveryDate; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 14px; font-size: 12px; opacity:0.7;" >
                    *delivery date may vary according to the provider 
                </div>
            </div>
            
            <?php 
                if($isDelivered) {
                    echo "
                        <div class='rateProduct'>
                            <h1>Rate this product <hr></h1>
                            <p id='warning' style='margin-bottom: 4px; font-size: 13px;'></p>
                            <form action='../../../../components/ratings/rate.php' onsubmit='return handleSubmit()' method='post'>
                                <div class='starCount'>
                                    <div class='ayw'>
                                        <input type='radio' name='stars' value='1' id='star1'>
                                        <input type='radio' name='stars' value='2' id='star2'>
                                        <input type='radio' name='stars' value='3' id='star3'>
                                        <input type='radio' name='stars' value='4' id='star4'>
                                        <input type='radio' name='stars' value='5' id='star5'>

                                        <label for='star1'>
                                            <div class='imageStar'>
                                                <img id='starImage1' src='../../../../resources/empty-star.png'>
                                            </div>
                                        </label>
                                        <label for='star2'>
                                            <div class='imageStar'>
                                                <img id='starImage2' src='../../../../resources/empty-star.png'>
                                            </div>
                                        </label>
                                        <label for='star3'>
                                            <div class='imageStar'>
                                                <img id='starImage3' src='../../../../resources/empty-star.png'>
                                            </div>
                                        </label>
                                        <label for='star4'>
                                            <div class='imageStar'>
                                                <img id='starImage4' src='../../../../resources/empty-star.png'>
                                            </div>
                                        </label>
                                        <label for='star5'>
                                            <div class='imageStar'>
                                                <img id='starImage5' src='../../../../resources/empty-star.png'>
                                            </div>
                                        </label>
                                    </div>
                                    <div class='aiw'>
                                        <p>poor</p>
                                        <p>average</p>
                                        <p>good</p>
                                        <p>great</p>
                                        <p>excellent</p>
                                    </div>
                                </div>
                                <div id='editArea'>
                                    <div id='inputs' class='inputs'>
                                        <textarea name='description' class='description' id='description' placeholder='description...'></textarea>
                                        <div class='desc'>
                                            <input type='reset' style='display: none;' id='resetInput' value='reset'>
                                            <label for='resetInput' id='reset' onclick='reset()'>reset</label>
                                            <input type='submit' class='submit' value='submit' name='postRating'>
                                        </div>
                                    </div>
                                    <div id='editBtn'>
                                        <p>Edit rating</p>
                                        <div class='editImg'>
                                            <img src='../../../../resources/edit.png' alt=''>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    ";
                }
                
            ?>
            

            <div class="address">
                <div class="Stitle"><p style="opacity: 0.8; font-size:14px;">shipping details</p></div>
                <div class="cont">
                    <div class="ho">
                        <img src="../../../../resources/icons8-home.gif" alt="home">
                    </div>
                    <div class="ad">
                        <?php echo $addressContent; ?>
                    </div>
                </div>
            </div>

            <div class="payment">
                <div class="Stitle"><p style="opacity: 0.8; font-size:14px;">price details</p></div>
                <ul class="list">
                    <li>
                        <p class="awbERII29_2j">Product price</p>
                        <p>₹<?php echo $prodPrice." ($prodQuantity)"?></p>
                    </li>
                    <li>
                        <p class="awbERII29_2j">Size</p>
                        <p><?php echo $prodSize;?></p>
                    </li>
                    <li>
                        <p class="awbERII29_2j">Delivery charge</p>
                        <p style="color: #4BAE4F; font-weight: 500;">Free</p>
                    </li>
                    <li>
                        <p class="awbERII29_2j">Payment method</p>
                        <p>UPI</p>
                    </li>
                    <li class="asl">
                        <p class="awbERII29_2j">Total amount</p>
                        <p>₹<?php echo $prodPrice*$prodQuantity;?></p>
                    </li>    
                </ul>
            </div>

            <div class="moreYouLike">
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

                                if($more['stock_status']) {

                                    //encryption 
                                    $ciphering = "AES-128-CTR";
                                    $iv_length = openssl_cipher_iv_length($ciphering);
                                    $options = 0;
                                    $encryption_iv = '1234567891021957';
                                    $encryption_key = "xfassoKey";
                                    $encrypted_id = openssl_encrypt($productId, $ciphering, $encryption_key, $options, $encryption_iv);


                                    $imageMore = base64_encode($more['product_image']);
                                    $imageTypeMore = "image/jpeg";
                                    echo "
                                        <a href='../../../../details/details.php?productId={$encrypted_id}' style='color: inherit; text-decoration: none;'>
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
                                                                    echo "<span><img src='../../../../resources/icons8-star-50.png' class='star'></span>";
                                                                }
                                                                for($k=0; $k<5-$averageStarCount; $k++) {
                                                                    echo "<span><img src='../../../../resources/empty-star.png' class='star'></span>";
                                                                }
                                                            }else {
                                                                for($k=0; $k<$averageStarCount-1; $k++) {
                                                                    echo "<span><img src='../../../../resources/icons8-star-50.png' class='star'></span>";
                                                                }
                                                                echo "<span><img src='../../../../resources/icons8-star-half-empty-50.png' class='star'></span>";
                                                                for($k=0; $k<5-$averageStarCount-1; $k++) {
                                                                    echo "<span><img src='../../../../resources/empty-star.png' class='star'></span>";
                                                                }
                                                            }
                                                            echo "&nbsp;{$averageStarCount}";
                                                        }else {
                                                            for($k=0; $k<5; $k++) {
                                                                echo "<span><img src='../../../../resources/empty-star.png' class='star'></span>";
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
        </div>
    </div>
</body>
<script>
    let warning = document.getElementById('warning');
    <?php 
        if($updateStarcount) {
            echo "
                warning.innerHTML = 'rating submitted succesfully...';
                warning.style.color= 'green';
                setTimeout(()=> {
                    warning.innerHTML = '';
                },4000);
            ";
        }  
    ?>

    let scaleLevel = <?php echo $scaleLevel;?>;


    let scale1 = document.getElementById('scale1');
    let scale2 = document.getElementById('scale2');
    let scale3 = document.getElementById('scale3');
    let del =document.getElementById('del');

    switch (scaleLevel) {
        case 7:
            scale1.setAttribute("src", '../../../../resources/accept.png');
            scale2.setAttribute("src", '../../../../resources/acceptGrey.png');
            scale3.setAttribute("src", '../../../../resources/acceptGrey.png');
            break;
        case 57:
            scale1.setAttribute("src", '../../../../resources/accept.png');
            scale2.setAttribute("src", '../../../../resources/accept.png');
            scale3.setAttribute("src", '../../../../resources/acceptGrey.png');
            break;
        case 100:
            scale1.setAttribute("src", '../../../../resources/accept.png');
            scale2.setAttribute("src", '../../../../resources/accept.png');
            scale3.setAttribute("src", '../../../../resources/accept.png');
            document.getElementById('orderStatus').innerHTML = "order processed";
            document.getElementById('orderTimer').style.display = 'none';
            break;
        default:
            del.innerHTML = "Order failed";
            break;
    }


    

    let scale = document.getElementById('scale');
        
    if(window.innerWidth <= 762) {
        scale.style.height = `${scaleLevel+3}%`;
        if(scaleLevel === 100) {
            scale.style.height = `${scaleLevel-3.4}%`;
        }
    }else {
        scale.style.width = `${scaleLevel}%`;
    }
    window.addEventListener('resize', ()=> {
        if(window.innerWidth <= 762) {
            scale.style.height = `${scaleLevel+3}%`;
            scale.style.width = 0;
            if(scaleLevel === 100) {
                scale.style.height = `${scaleLevel-3.4}%`;
            }
        }else {
            scale.style.height = 0;
            scale.style.width = `${scaleLevel}%`;
        }
    })

    let star = [];
    
    for (let i = 1; i <= 5; i++) {
        let starElement = document.getElementById(`star${i}`);
        star.push(starElement); 
    }

    for (let j = 0; j < 5; j++) {
        let empty = '../../../../resources/empty-star.png';
        let filled = '../../../../resources/icons8-star-50.png';
        star[j].addEventListener('change', () => {
            warning.innerHTML = "";
            for (let i = 0; i <= j; i++) {
                if (star[i].checked) {
                    for(let k=0; k<=i; k++) {
                        document.getElementById(`starImage${k + 1}`).src = filled;
                        
                        for(let m=4; m>=k+1; m--){
                            document.getElementById(`starImage${m + 1}`).src =empty;
                        }
                    }
                    
                }
            }
        });
    }

    document.getElementById("reset").addEventListener("click", ()=> {
        let empty = '../../../../resources/empty-star.png';
        for (let i = 0; i < 5; i++) {
            document.getElementById(`starImage${i + 1}`).src =empty;
        }
    });

    let description = document.getElementById('description');

    function reset() {
        description.textContent = "";
    }
    let editBtn = document.getElementById('editBtn');
    let inputs = document.getElementById('inputs');
    let starSet = false;
    let descriptionSet = false;
    <?php 
        if(isset($starCount)) {
            echo "
                star[{$starCount}-1].checked = true;
                thing($starCount);
                starSet = true;
            ";
        }
        if(isset($description)) {
            echo "
                descriptionSet = true;
                description.innerHTML = '{$description}';
            ";
        }
    ?>   

    if(starSet && descriptionSet) {
        inputs.style.display = 'none';
    }else {
        editBtn.style.display = 'none';
    }

    editBtn.addEventListener('click', ()=> {
        inputs.style.display = 'flex';
        editBtn.style.display = 'none';
    })
    
    function thing(num) {
        let empty = '../../../../resources/empty-star.png';
        let filled = '../../../../resources/icons8-star-50.png';
        for (let j = 0; j < num; j++) {
            document.getElementById(`starImage${j + 1}`).src = filled;
            
        }
    }

    function user(x) {
        if(x === true) { 
            window.location.href = '../../edit-profile.php';
        }
        else {
            window.history.back();
        }
    }

    function handleSubmit() {
        let starFilled;
        for(let i=0; i<5; i++) {
            if(star[i].checked) {
                starFilled = true;
                break;
            }
        } 
        if(!starFilled || description.value === "") {
            if(!starFilled && description.value === "") {
                return true;
            }
            warning.innerHTML = "please fill out all the fields";
            warning.style.color = "red";
            return false;
        }
        return true;
    }

    description.addEventListener("input", ()=> {
        warning.innerHTML = "";
    });
    
</script>
</html>