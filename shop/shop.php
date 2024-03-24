<?php 
    require('../connections/productdb.php');
    require('../components/ratings/ratingAPI.php');
    
    $productSqlQuery = "SELECT * FROM products";
    $productQueryResult = mysqli_query($conn, $productSqlQuery);

    if(isset($_COOKIE['lowToHigh'])) {
        $productSqlQuery = "SELECT * FROM products ORDER BY product_price ASC";
        $queryLow = "ORDER BY product_price ASC";
        $productQueryResult = mysqli_query($conn, $productSqlQuery);
    }elseif(isset($_COOKIE['highToLow'])) {
        $productSqlQuery = "SELECT * FROM products ORDER BY product_price DESC";
        $productQueryResult = mysqli_query($conn, $productSqlQuery);
    }

    $ratingArray = array();
    $ratingArray[] = json_decode($ratingsOfProd, true);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />


    <link type="image/png" sizes="16x16" rel="icon" href=".../icons8-filter-16.png">
    
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/shop.css">
    <title>Document</title>
</head>
<body>
    <div class="_45y"></div>
    <div id="nav" class="nav">
        <div class="checkbox">
            <input type="checkbox" id="ham-menu">
            <label class="ham" for="ham-menu">
                <div class="hamburger">
                    <span id="bar1" class="bar1"></span>
                    <span id="bar2"  class="bar2"></span>
                    <span id="bar3"  class="bar3"></span>
                </div>
            </label>
        </div>
        <div id="_f3fs" style="cursor: pointer;" class="nav-logo primary">
            XFASSO
        </div>
        <script>
            document.getElementById('_f3fs').addEventListener('click', ()=> {
                window.location.href = '../';
            })
        </script>
        <ul class="nav-links">
            <li class="secondary"><a class="_u2c" href="../index.html">Home</a></li>
            <li class="secondary"><a class="_u2c" href="../about/about.html">About</a></li>
        </ul>
        <div class="nav-login-cart">
            <ul class="login-cart">
                <li class="primary">
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
                </li>
            </ul>
        </div>
    </div>
    <div id="new-nav-menu" class="new-nav-menu">
        <div class="another">
            <ul class="new-nav-links">
                <li class="secondary"><a class="_u2c" href="../index.html">Home</a></li>
                <li class="secondary"><a class="_u2c" href="../about/about.html">About</a></li>
            </ul>
            <br>
            <br>
            <br>
            <br>
            <hr>
            <ul class="new-nav-social-links">
                <li>
                    <a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-instagram-48.png" width="24px" alt="instagram">
                    </a>
                </li>
                <li><a href="#" class="_u2c">
                    <img src="../resources/socialmedia/icons8-facebook-48.png" width="24px" alt="facebook">
                </a></li>
                <li><a href="#" class="_u2c">
                    <img src="../resources/socialmedia/icons8-pinterest-48.png" width="24px" alt="pinterest">
                </a></li>
                <li><a href="#" class="_u2c">
                    <img src="../resources/socialmedia/icons8-twitterx-50.png" width="24px" alt="twitter X">
                </a></li>
            </ul>
        </div>
    </div>
    <div class="shopmain" id="shopmain">
        <h1 class="primary" style="font-weight:600;">Products</h1>

        <div class="filter">
            <input type="checkbox" id="_1menu-filter">
            <label for="_1menu-filter">
                <div class="_i92">
                    <div id="filter-sort" class="filter-sort">
                        <span><img src="../resources/filter.png" width="21px"></span>
                        <p class="secondary">filter and sort</p>
                    </div>
                    <?php 

                        $productSqlQueryMen = "SELECT * FROM products WHERE product_gender = 'men'";
                        $productQueryResultMen = mysqli_query($conn, $productSqlQueryMen);

                        $productSqlQueryWomen = "SELECT * FROM products WHERE product_gender = 'women'";
                        $productQueryResultWomen = mysqli_query($conn, $productSqlQueryWomen);

                        if(isset($_COOKIE['men-checked'])&&isset($_COOKIE['women-checked'])){
                            $numberOfProducts = mysqli_num_rows($productQueryResult);
                        }
                        elseif(isset($_COOKIE['men-checked'])) {
                            $numberOfProducts = mysqli_num_rows($productQueryResultMen);
                        } elseif(isset($_COOKIE['women-checked'])){
                            $numberOfProducts = mysqli_num_rows($productQueryResultWomen);
                        }else {
                            $numberOfProducts = mysqli_num_rows($productQueryResult);
                        }

                        echo "<div class='product-count secondary'>{$numberOfProducts} products</div>";
                    ?>
                </div>
            </label>
            <div id="filter-menu" class="filter-menu" action="" method="post">
                <div class="filter-options">
                    <p>filter</p>
                    <div class="_m7y">
                        <input type="checkbox" id="men-products">
                        <label for="men-products">Men</label>
                    </div>
                    <div class="_w7y">
                        <input type="checkbox" id="women-products">
                        <label for="women-products">Women</label>
                    </div>
                </div>
                <div class="sort-options">
                    <p>sort</p>
                    <div class="p1_9">
                        <input type="checkbox" id="low-high">
                        <label for="low-high">Price, low to high</label>
                    </div>
                    <div class="p9_1">
                        <input type="checkbox" id="high-low">
                        <label for="high-low">Price, high to low</label>
                    </div>
                </div>
                <div class="menu-button">
                    <button id="reset" class="reset" id="reset">Reset all</button>
                    <button id="apply" class="button-menu">Apply</button>
                </div>
            </div>
        </div>

        <script>


            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }

            var reset = document.getElementById('reset');
            var apply = document.getElementById('apply');

            var menProducts = document.getElementById('men-products');
            var womenProducts = document.getElementById('women-products');
            var lowToHigh = document.getElementById('low-high');
            var highToLow = document.getElementById('high-low');
            
            lowToHigh.addEventListener('change',()=> {
                if(highToLow.checked) {
                    highToLow.checked = false;   
                }
            })
            highToLow.addEventListener('change', ()=> {
                if(lowToHigh.checked) {
                    lowToHigh.checked = false;
                }
            })

            menProducts.addEventListener('change', ()=> {
                if(womenProducts.checked) {
                    womenProducts.checked =false;
                }
            })
            womenProducts.addEventListener('change', ()=> {
                if(menProducts.checked) {
                    menProducts.checked =false;
                }
            })

            reset.addEventListener('click', () => {
                filter.checked = false;

                setTimeout(()=> {
                    filterMenu.style.left = "-110%";
                }, 700)

                menProducts.checked = false;
                womenProducts.checked = false;
                lowToHigh.checked = false;
                highToLow.checked = false;

                window.location.reload();

                document.cookie = "men-checked=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "women-checked=; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
                document.cookie = "lowToHigh=lowToHighTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
                document.cookie = "highToLow=highToLowTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";

            })

            var cookieExpires = new Date(Date.now() + 100 * 130).toUTCString();

            apply.addEventListener('click', ()=> {
                
                filterMenu.style.left = "-110%";
                filter.checked = false;

                //men-checked

                if(menProducts.checked) {
                    document.cookie = "men-checked=menTrue; expires="+ cookieExpires +"; path=/";
                    
                }else {
                    document.cookie = "men-checked=menTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
                    
                }

                //women-checked

                if(womenProducts.checked) {
                    document.cookie = "women-checked=womenTrue; expires="+ cookieExpires +"; path=/";
                }else {
                    document.cookie = "women-checked=womenTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
                }

                //Low to high

                if(lowToHigh.checked) {
                    document.cookie = "lowToHigh=lowToHighTrue; expires="+ cookieExpires +"; path=/";
                }else {
                    document.cookie = "lowToHigh=lowToHighTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
                }
                
                //High to low

                if(highToLow.checked) {
                    document.cookie = "highToLow=highToLowTrue; expires="+ cookieExpires +"; path=/";
                }else {
                    document.cookie = "highToLow=highToLowTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
                }
                
                window.location.reload();
            })


            if(getCookie('men-checked')) {
                menProducts.checked =true;
            }
            if(getCookie('women-checked')){
                womenProducts.checked =true;
            }
            if(getCookie('lowToHigh')) {
                lowToHigh.checked =true;
            }
            if(getCookie('highToLow')) {
                highToLow.checked =true;
            }
        </script>

        <div id="products" class='products'>
            <div class='card-container'>

                <?php

                    if(isset($_COOKIE['men-checked'])) {
                        
                        if(isset($_COOKIE['highToLow'])) {
                            $productSqlQuery = "SELECT * FROM products WHERE product_gender = 'men' ORDER BY product_price DESC";
                            $productQueryResult = mysqli_query($conn, $productSqlQuery);
                        }
                        elseif(isset($_COOKIE['lowToHigh'])) {
                            $productSqlQuery = "SELECT * FROM products WHERE product_gender = 'men' ORDER BY product_price ASC";
                            $productQueryResult = mysqli_query($conn, $productSqlQuery);
                        }
                        else {   
                            $productSqlQuery = "SELECT * FROM products WHERE product_gender = 'men'";
                            $productQueryResult = mysqli_query($conn, $productSqlQuery);
                        }
                    }
                    else if(isset($_COOKIE['women-checked'])) {
                        if(isset($_COOKIE['highToLow'])) {
                            $productSqlQuery = "SELECT * FROM products WHERE product_gender = 'women' ORDER BY product_price DESC";
                            $productQueryResult = mysqli_query($conn, $productSqlQuery);
                        }
                        elseif(isset($_COOKIE['lowToHigh'])) {
                            $productSqlQuery = "SELECT * FROM products WHERE product_gender = 'women' ORDER BY product_price ASC";
                            $productQueryResult = mysqli_query($conn, $productSqlQuery);
                        }
                        else {   
                            $productSqlQuery = "SELECT * FROM products WHERE product_gender = 'women'";
                            $productQueryResult = mysqli_query($conn, $productSqlQuery);
                        }
                    }

                    
                    
                    if(mysqli_num_rows($productQueryResult)>0) {

                        //star rating pt1

                        function isInteger($value) {
                            return is_numeric($value) && intval($value) == $value;
                        }
                        $totalElements = 0;
                        $totalStarCount = 0;
                        while ($productRow = mysqli_fetch_assoc($productQueryResult)) {
                            $productId = $productRow['product_id'];
                            $totalStarCount = 0;
                            $totalElements = 0;

                            // Calculate total star count and total number of elements for the current product
                            for ($i = 0; $i < count($ratingArray[0]); $i++) {
                                for ($j = 0; $j < count($ratingArray[0][$i]); $j++) {
                                    if ($ratingArray[0][$i][$j]['productID'] == $productId) {
                                        $totalStarCount += $ratingArray[0][$i][$j]['starCount'];
                                        $totalElements++;
                                    }
                                }
                            }

                            // Calculate average star count for the current product
                            if ($totalElements > 0) {
                                $averageStarCount = number_format($totalStarCount / $totalElements, 1);
                            } else {
                                $averageStarCount = 0;
                            }
                            // set avg_star count to DB
                            $quer = "UPDATE products SET avg_star='{$averageStarCount}' WHERE product_id = '{$productId}'";
                            $querRUN = mysqli_query($conn, $quer);
                            
                            $productId = "productIdOfXfassoYes {$productRow['product_id']}";

                            //star rate pt1 end

                            //encrypting
                            $ciphering = "AES-128-CTR";
                            $iv_length = openssl_cipher_iv_length($ciphering);
                            $options = 0;
                            $encryption_iv = '1234567891021957';
                            $encryption_key = "xfassoKey";
                            $encrypted_id = openssl_encrypt($productId, $ciphering, $encryption_key, $options, $encryption_iv);


                            $imageData = base64_encode($productRow['product_image']);
                            $imageType = "image/jpeg";
                            echo "
                                <div id='{$encrypted_id}' class='card'>
                                    <a style='color: inherit; text-decoration: none;' href='../details/details.php?productId={$encrypted_id}'>
                                        <div class='product-img'>
                                            <img src='data:$imageType;base64,$imageData' alt='img'>
                                        </div>
                                        <div class='content-product'>
                                            <h2 id='primary'>{$productRow['product_name']}</h2>
                                            <div class='price-button'>
                                                <p class='secondary'>₹{$productRow['product_price']}</p>
                                               


                                                <p class='secondary rate'>"; 
                                                // Star rating code pt2
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
                                                    echo " {$averageStarCount}";
                                                }else {
                                                    for($k=0; $k<5; $k++) {
                                                        echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                                    }
                                                }
                                                //star rate pt2 end
                                                echo "</p>
                                                <a href='../details/details.php?productId={$encrypted_id}'><button class='button-products'>view</button></a>
                                            </div>
                                        </div>
                                    </a>
                                </div>  
                            ";
                        }
                        
                    }

                ?>

            </div>
        </div>
        <br>
        <br>
        <hr>
        <div class="footer">
            <div class="quick-link">
                <h4 class="primary footer-head">Quick links</h4>
                <ul>
                    <li><a onclick="menCookie()" href="./shop.php">Men</a></li>
                    <li><a onclick="womenCookie()" href="./shop.php">Women</a></li>
                    <li><a onclick="window.location.reload()" style="cursor: pointer;">Shop All</a></li>
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
        <div class="email-us">
            <h1 class="primary">Email Us.</h1>
            <form action="../connections/mailto.php" method="post">
                <input type="text" class="_i044d" name="email-text" value="" required placeholder="Your suggetions goes here">
                <input type="submit" name="submit" onclick="emailSubmit()" id="email-submit">
                <label for="email-submit" class="btn-email">
                    <img src="../resources/icons8-arrow.gif" alt="->">
                </label>
                <p id="emailSending" class="emailSending secondary"></p>
                    
                <br>
                <br><br>
                <ul style="display: flex; justify-content: center;" class="new-nav-social-links">
                    <li>
                        <a href="#" class="_u2c">
                            <img src="../resources/socialmedia/icons8-instagram-48.png" width="24px" alt="instagram">
                        </a>
                    </li>
                    <li><a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-facebook-48.png" width="24px" alt="facebook">
                    </a></li>
                    <li><a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-pinterest-48.png" width="24px" alt="pinterest">
                    </a></li>
                    <li><a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-twitterx-50.png" width="24px" alt="twitter X">
                    </a></li>
                </ul>
            </form>
            <p class="_c45 secondary">&copy; xfasso 2024</p>
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
    <script src="./shop.js"></script>
</body>
</html>


<?php 
    mysqli_close($conn);
?>