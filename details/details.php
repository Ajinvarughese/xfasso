<?php
    require('../connections/productdb.php');
    require('../components/ratings/ratingAPI.php');

    $ratingArray = array();
    $ratingArray[] = json_decode($ratingsOfProd, true);

    if(isset($_GET['productId'])) {

        $product_id = $_GET['productId'];
        // echo "Original String: " . $simple_string;
        $ciphering = "AES-128-CTR"; 
        // $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        // $encryption_iv = '1234567891021957';
        // $encryption_key = "xfassoKey";
        // $encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);
        // echo "Encrypted String: " . $encryption . "\n";

        //decrypting
        $decryption_iv = '1234567891021957';
        $decryption_key = "xfassoKey";
        $decrypted_id = openssl_decrypt($product_id, $ciphering, $decryption_key, $options, $decryption_iv);  
        
        $splitId = explode(' ', $decrypted_id);

        $decrypted_id = $splitId[1];
    
        //query
        $detailsQuery = "SELECT products.avg_star, products.product_id, products.product_name, products.product_price, products.product_image, products.product_gender, product_images.img_front, product_images.img_back, product_images.img_right, product_images.img_left, product_images.product_desc FROM products INNER JOIN product_images ON products.product_id = product_images.product_id WHERE products.product_id = {$decrypted_id}";
        $deatilsResult = mysqli_query($conn, $detailsQuery);

        if(mysqli_num_rows($deatilsResult)>0) {
            $details = mysqli_fetch_assoc($deatilsResult);

            //front
            $imageData1 = base64_encode($details['img_front']);
            $imageType1 = "image/jpeg";

            //back
            $imageData2 = base64_encode($details['img_back']);
            $imageType2 = "image/jpeg";

            //left
            $imageData3 = base64_encode($details['img_left']);
            $imageType3 = "image/jpeg";

            //right
            $imageData4 = base64_encode($details['img_right']);
            $imageType4 = "image/jpeg";
        } 
    }else {
        header('Location: ../shop/shop.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $details['product_name']?></title>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">      


    <link rel="stylesheet" href="../css/details.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .nav {
            border-bottom: 1px solid #d2d5d9;
            position: fixed;
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            z-index: 1;
            height: 9vh;
            width: 100%;
            background: rgb(255, 255, 255);
        }
    </style>

</head>
<body>
    <div class="nav">
        <a style="text-decoration: none; color: inherit;" href="../index.html"><h1>LOGO</h1></a>
        <div class="cart">
                    
            <a href="../cart/cart.php" id="zIca" style="text-decoration: none; color: inherit;">
                <i class="fas fa-shopping-cart" style="color: #12263a;">
                </i>

                <style>
                    #cart_num {
                        background: rgba(239, 50, 50, 0.811);
                        padding: 3px;
                        height: 18px;
                        display: flex;
                        color: #fff;
                        align-items: center;
                        justify-content: center;
                        width: 18px;
                        border-radius: 100%;
                        position: absolute;
                        top: -40%;
                        left: 75%;
                    }
                    #zIca {
                        position: relative;
                    }
                </style>
                
                <div id="cart_num">
                    <div id="number"></div>
                </div>
                <script>
                    var cart_num = document.getElementById('cart_num');
                    var number = document.getElementById('number');
                    fetch('../num/num.php')
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

    <div class="main">
        <div class = "card-wrapper">
            <div class = "card">
                <div class = "product-imgs">
                    <?php 
                        echo "
                        
                            <div class = 'img-display'>
                                <div class = 'img-showcase'>
                                <img src='data:$imageType1;base64,$imageData1' alt = 'shoe image'>
                                <img src='data:$imageType2;base64,$imageData2' alt = 'shoe image'>
                                <img src='data:$imageType3;base64,$imageData3' alt = 'shoe image'>
                                <img src='data:$imageType4;base64,$imageData4' alt = 'shoe image'>
                                </div>
                            </div>
                        
                        ";
                    ?>
                    <?php 
                        echo "
                        <div class = 'img-select'>
                            <div class = 'img-item'>
                            <a href = '#' data-id = '1'>
                                <img src='data:$imageType1;base64,$imageData1' alt = 'shoe image'>
                            </a>
                            </div>
                            <div class = 'img-item'>
                            <a href = '#' data-id = '2'>
                                <img src='data:$imageType2;base64,$imageData2' alt = 'shoe image'>
                            </a>
                            </div>
                            <div class = 'img-item'>
                            <a href = '#' data-id = '3'>
                                <img src='data:$imageType3;base64,$imageData3' alt = 'shoe image'>
                            </a>
                            </div>
                            <div class = 'img-item'>
                            <a href = '#' data-id = '4'>
                                <img src='data:$imageType4;base64,$imageData4' alt = 'shoe image'>
                            </a>
                            </div>
                        </div>

                        ";
                    
                    ?>
                </div>

                <div class = "product-content">
                    <h2 class = "product-title"><?php echo $details['product_name'] ?></h2>

                    <div class = "product-price">
                        <h2 class = "new-price">₹<?php echo $details['product_price'] ?><span> &nbsp;SALE</span></h2>
                        <div class="rate">
                            <?php 
                                function isInteger($value) {
                                    // Check if the value is numeric and if its integer value is equal to itself
                                    // This checks if the value is a numeric string or integer
                                    return is_numeric($value) && intval($value) == $value;
                                }
                                $averageStarCount = $details['avg_star'];
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
                                    echo "<p class='secondary'>&nbsp;{$averageStarCount} rating</p>";
                                }else {
                                    for($k=0; $k<5; $k++) {
                                        echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="product-size">
                        <div class="size">
                            <ul>
                                <li>
                                    <input type="radio" id="s" name='size' checked>
                                    <label class="size-box _s2active" id="size-boxS" for="s">S</label>
                                </li>
                                <li><input type="radio" id="m" name='size'>
                                    <label class="size-box" id="size-boxM" for="m">M</label>
                                </li>
                                <li><input type="radio" id="l" name='size'>
                                    <label class="size-box" id="size-boxL" for="l">L</label>
                                </li>
                                <li><input type="radio" id="xl" name='size'>
                                    <label class="size-box" id="size-boxXL" for="xl">XL</label>
                                </li>
                                <li><input type="radio" id="xxl" name='size'>
                                    <label class="size-box" id="size-boxXxl" for="xxl">XXL</label>
                                </li>
                            </ul>
                        </div>
                        <script>
                            var s = document.getElementById('s');
                            var m = document.getElementById('m');
                            var l = document.getElementById('l');
                            var xl = document.getElementById('xl');
                            var xxl =document.getElementById('xxl');

                            var labelS = document.getElementById('size-boxS')
                            var labelM = document.getElementById('size-boxM')
                            var labelL = document.getElementById('size-boxL')
                            var labelXl =document.getElementById('size-boxXL')
                            var labelXxl =document.getElementById('size-boxXxl');

                            s.addEventListener('change', ()=> {
                                labelS.style.background = '#12263a';
                                labelS.style.color = '#fff';

                                labelM.style.background = '#fff';
                                labelM.style.color = '#12263a';

                                labelL.style.background = '#fff';
                                labelL.style.color = '#12263a';

                                labelXl.style.background = '#fff';
                                labelXl.style.color = '#12263a';

                                labelXxl.style.background = '#fff';
                                labelXxl.style.color = '#12263a';
                            })
                            m.addEventListener('change', ()=> {
                                labelS.style.background = '#fff';
                                labelS.style.color = '#12263a';

                                labelM.style.background = '#12263a';
                                labelM.style.color = '#fff';

                                labelL.style.background = '#fff';
                                labelL.style.color = '#12263a';

                                labelXl.style.background = '#fff';
                                labelXl.style.color = '#12263a';

                                labelXxl.style.background = '#fff';
                                labelXxl.style.color = '#12263a';
                            })
                            l.addEventListener('change', ()=> {
                                labelS.style.background = '#fff';
                                labelS.style.color = '#12263a';

                                labelM.style.background = '#fff';
                                labelM.style.color = '#12263a';

                                labelL.style.background = '#12263a';
                                labelL.style.color = '#fff';

                                labelXl.style.background = '#fff';
                                labelXl.style.color = '#12263a';

                                labelXxl.style.background = '#fff';
                                labelXxl.style.color = '#12263a';
                            })
                            xl.addEventListener('change', ()=> {
                                labelS.style.background = '#fff';
                                labelS.style.color = '#12263a';

                                labelM.style.background = '#fff';
                                labelM.style.color = '#12263a';

                                labelL.style.background = '#fff';
                                labelL.style.color = '#12263a';

                                labelXl.style.background = '#12263a';
                                labelXl.style.color = '#fff';

                                labelXxl.style.background = '#fff';
                                labelXxl.style.color = '#12263a';
                            })
                            xxl.addEventListener('change', ()=> {
                                labelS.style.background = '#fff';
                                labelS.style.color = '#12263a';

                                labelM.style.background = '#fff';
                                labelM.style.color = '#12263a';

                                labelL.style.background = '#fff';
                                labelL.style.color = '#12263a';

                                labelXl.style.background = '#fff';
                                labelXl.style.color = '#12263a';

                                labelXxl.style.background = '#12263a';
                                labelXxl.style.color = '#fff';
                                
                            })
                        </script>
                    </div>
                    <div class = "purchase-info">
                        <input id="quantity" type = "number" min = "1" value = "1" step="1" max="5">
                        <script>
                            const quanity = document.getElementById('quantity');
                            quanity.addEventListener('input', ()=> {
                                const value = quanity.value;
                                const cleanValue = value.replace(/[^0-9]/g, '');
                                quanity.value = cleanValue;
                            })

                        </script>
                        <h6>max quantity is 5</h6>
                        <form action='<?php echo htmlspecialchars('../connections/addcart.php')?>' method="post">
                            <button name="addCa" id="addCa" type = "submit" class = "btn btn1">
                                Add to Cart <i class = "fas fa-shopping-cart"></i>
                            </button>
                            <p id='limitW' style="font-size: 13px; color: red; margin-top: -4px; margin-bottom: 9.8px;"></p>
                        </form>
                        <form action="<?php echo htmlspecialchars('../connections/addcart.php')?>" method="post">
                            <button name="buyNow" id="buyNow" type = "submit" class = "btn btn2">
                                Buy Now <i class = "fas fa-bolt"></i>
                            </button>
                        </form>
                        <script>
                                var quantity = document.getElementById('quantity');
                                function products() {
                                    var cookieExpires = new Date(Date.now() + 1 * 60 * 60 * 1000).toUTCString();
                                    if(s.checked) {
                                        <?php 
                                            // Your data to be encrypted
                                                $dataToEncrypt = "s";

                                                // Generate a random encryption key
                                                $encryptionKey = openssl_random_pseudo_bytes(32); // 256-bit key for AES-256

                                                // Generate a random initialization vector (IV)
                                                $iv = openssl_random_pseudo_bytes(16); // 128-bit IV for AES-256

                                                // Encrypt the data
                                                $encryptedData = openssl_encrypt($dataToEncrypt, 'AES-256-CBC', $encryptionKey, 0, $iv);

                                                // To store or transmit the encrypted data, you can encode it in base64
                                                $encryptedDataBase64 = base64_encode($encryptedData);  
                                        ?>
                                        document.cookie = "ikwnquuS19=<?php echo $encryptedDataBase64?>; expires="+ cookieExpires +"; path=/";
                                    }else if(m.checked) {
                                        <?php 
                                                $dataToEncrypt = "m";
                                                $encryptionKey = openssl_random_pseudo_bytes(32);
                                                $iv = openssl_random_pseudo_bytes(16);
                                                $encryptedData = openssl_encrypt($dataToEncrypt, 'AES-256-CBC', $encryptionKey, 0, $iv);
                                                $encryptedDataBase64 = base64_encode($encryptedData);  
                                        ?>
                                        document.cookie = "ikwnquuM19=<?php echo $encryptedDataBase64?>; expires="+ cookieExpires +"; path=/";
                                    }else if(l.checked) {
                                        <?php 
                                                $dataToEncrypt = "l";
                                                $encryptionKey = openssl_random_pseudo_bytes(32);
                                                $iv = openssl_random_pseudo_bytes(16);
                                                $encryptedData = openssl_encrypt($dataToEncrypt, 'AES-256-CBC', $encryptionKey, 0, $iv);
                                                $encryptedDataBase64 = base64_encode($encryptedData);  
                                        ?>
                                        document.cookie = "ikwnquuL19=<?php echo $encryptedDataBase64?>; expires="+ cookieExpires +"; path=/";
                                    }else if(xl.checked) {
                                        <?php 
                                                $dataToEncrypt = "xl";
                                                $encryptionKey = openssl_random_pseudo_bytes(32);
                                                $iv = openssl_random_pseudo_bytes(16);
                                                $encryptedData = openssl_encrypt($dataToEncrypt, 'AES-256-CBC', $encryptionKey, 0, $iv);
                                                $encryptedDataBase64 = base64_encode($encryptedData);  
                                        ?>
                                        document.cookie = "ikwnquuXL19=<?php echo $encryptedDataBase64?>; expires="+ cookieExpires +"; path=/";
                                    }else if(xxl.checked) {
                                        <?php 
                                                $dataToEncrypt = "xxl";
                                                $encryptionKey = openssl_random_pseudo_bytes(32);
                                                $iv = openssl_random_pseudo_bytes(16);
                                                $encryptedData = openssl_encrypt($dataToEncrypt, 'AES-256-CBC', $encryptionKey, 0, $iv);
                                                $encryptedDataBase64 = base64_encode($encryptedData);  
                                        ?>
                                        document.cookie = "ikwnquuXXL19=<?php echo $encryptedDataBase64?>; expires="+ cookieExpires +"; path=/";
                                    }
                                    document.cookie = `productId=<?php echo $_GET['productId']?>; expires=${cookieExpires}; path=/`;
                                    document.cookie = `quantity= ${quantity.value}; expires=${cookieExpires}; path=/`;
                                }



                                document.getElementById('addCa').addEventListener('click', ()=> {
                                    products();
                                });

                                document.getElementById('buyNow').addEventListener('click', ()=> {
                                    products();
                                })

                                
                            </script>
                    </div>
                    <div class = "product-detail">
    



                        <h2>about this item: </h2>
                        <p><?php echo $details['product_desc'];?></p>
                        
                        
                        <div class="shipping" style="margin-top: 18px;">
                            <div class="_s32h">
                                <input type="checkbox" id="shipping">
                                <label for="shipping">Shipping info<i id="_i6" class="fa fa-caret-down" aria-hidden="true"></i></label>
                            </div>
                            <div id="shipping-content" class=" shipping-content">
                                <p>Free shipping available on all order!</p>
                                <br>
                                <p>We ship all orders within <span style="font-weight: 600;">[days_count] business days</span>!</p>
                            </div>
                        </div>

                        <div class="shipping">
                            <div class="_s32h">
                                <input type="checkbox" id="return">
                                <label for="return">Returns<i id="_i7" class="fa fa-caret-down" aria-hidden="true"></i></label>
                            </div>
                            <div id="return-content" class=" shipping-content">
                                <p> We do not accept any return of orders. our <a href="../policy/return.html">return policy</a></p>
                            </div>
                        </div>
                        <script>
                            var shipping =document.getElementById('shipping');

                            shipping.addEventListener('change', ()=> {
                                if(shipping.checked) {
                                    document.getElementById('_i6').classList.remove('fa-caret-down');
                                    document.getElementById('_i6').classList.add('fa-caret-up');
                                    document.getElementById('shipping-content').style.display ='block';
                                }else {
                                    document.getElementById('_i6').classList.remove('fa-caret-up');
                                    document.getElementById('_i6').classList.add('fa-caret-down');
                                    document.getElementById('shipping-content').style.display ='none';
                                }
                            })
                            var returnI = document.getElementById('return');

                            returnI.addEventListener('change', ()=> {
                                if(returnI.checked) {
                                    document.getElementById('_i7').classList.remove('fa-caret-down');
                                    document.getElementById('_i7').classList.add('fa-caret-up');
                                    document.getElementById('return-content').style.display ='block';
                                }else {
                                    document.getElementById('_i7').classList.remove('fa-caret-up');
                                    document.getElementById('_i7').classList.add('fa-caret-down');
                                    document.getElementById('return-content').style.display ='none';
                                }
                            })
                        </script>
                        
                        <ul>
                            <li>Available: <span>in stock</span></li>
                            <li>Category: <span><?php echo $details['product_gender'] ?></span></li>
                            <li>Shipping Fee: <span>Free Shipping</span></li>
                        </ul>

                        <div class="ratings">
                            <?php 
                                ratings('productID', $ratingArray);
                                function ratings($key, $ratingArray) {
                                    for($i=0; $i<count($ratingArray[0]);$i++) {
                                        for($j=0; $j<count($ratingArray[0][$i]); $j++) {
                                            echo $ratingArray[0][$i][$j][$key];
                                        }
                                    }
                                }
                                

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <style>
            .more {
                display: flex;
                overflow: auto hidden;
                align-items: center;
                gap: 1.2rem;
                justify-content: flex-start;
                
            }
            .card-more {
                border: 1px solid #d2d5d9;
                flex-grow: calc(2rem);
                min-width: 186px;
                max-width: 330px;
                min-height: 180px;
            }
            .more::-webkit-scrollbar {
                display: none;
            }
        </style>
    
        <div class="_p1">
            <hr>
            <h2 style="color: #12263a;">More you would like</h2>
            <br>
            <div class="more">

                <?php 
                    $moreSqlQuery = "SELECT * FROM products WHERE product_gender = '{$details['product_gender']}' ORDER BY RAND()";
                    $moreSqlResult = mysqli_query($conn, $moreSqlQuery);

                    if(mysqli_num_rows($moreSqlResult)>0) {
                        while($more = mysqli_fetch_assoc($moreSqlResult)) {

                            $productId = "productIdOfXfassoYes {$more['product_id']}";

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
                                <a href='./details.php?productId={$encrypted_id}' style='color: inherit; text-decoration: none;'>
                                    <div class='card-more'>
                                        <div class='img-more'>
                                            <img src='data:$imageTypeMore;base64,$imageMore' alt=''>
                                        </div>
                                        <div class='content-more'>
                                            <div style='padding: 5px 10px;' class='title'>{$more['product_name']}</div>
                                            <div style='padding:0 10px 5px 10px;' class='price'>\${$more['product_price']}</div>
                                        </div>
                                    </div>
                                </a>
                            ";
                        }
                    }
                ?>
            </div>
        </div>

        
      
        <div style="display: block; padding: 0;" class="footer">
        <br>
        <hr>
            <div class="footer">
                <div class="quick-link">
                    <h4 class="primary footer-head">Quick links</h4>
                    <ul>
                        <li><a onclick="menCookie()" href="../shop/shop.php">Men</a></li>
                        <li><a onclick="womenCookie()" href="../shop/shop.php">Women</a></li>
                        <li><a href="../shop/shop.php">Shop All</a></li>
                    </ul>
                </div>
                <div class="info">
                    <h4 class="primary footer-head">Info</h4>
                    <ul>
                        <li><a href="../about/">About</a></li>
                        <li><a href="../policies/shipping/">Shipping policy</a></li>
                        <li><a href="../policies/return/">Return policy</a></li>
                        <li><a href="../policies/terms/">Terms and Conditions</a></li>
                        <li><a href="../policies/privacy/">Privacy policy</a></li>
                    </ul>
                </div>
                <div class="our-mission">
                    <h4 class="primary footer-head">Our mission</h4>
                    <p class="secondary">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum quibusdam alias excepturi corporis fuga aut beatae amet repudiandae. Commodi, placeat earum</p>
                </div>
            </div>
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
                <script>
                    function emailSubmit() {
                        emailSending.textContent = 'Sending email...'
                        emailSending.style.display = 'block';
                    }
                </script>

                <p class="_c45 secondary">&copy; brand 2023</p>
            </div>
        </div>
    </div>

    <script>
        function menCookie() {
            var cookieExpires = new Date(Date.now() + 100 * 30).toUTCString();
            document.cookie = "men-checked=menTrue; expires="+ cookieExpires +"; path=/";
        }
        function womenCookie() {
            var cookieExpires = new Date(Date.now() + 100 * 30).toUTCString();
            document.cookie = "women-checked=womenTrue; expires="+ cookieExpires +"; path=/";
        }
    </script>
    <script src="details.js"></script>
  </body>
</html>



<?php  
    mysqli_close($conn)
?>