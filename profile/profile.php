<?php 
    require '../connections/productdb.php';

    if(isset($_COOKIE['XassureUser'])) {
        $emailId = $_COOKIE['XassureUser'];

        //decrypting
        $ciphering = "AES-128-CTR";
        $options = 0;
        $decryption_iv = '1234567891021957';
        $decryption_key = "xfassoKey";
        $decrypted_id = openssl_decrypt($emailId, $ciphering, $decryption_key, $options, $decryption_iv);
        $email = $decrypted_id;

        $qTitle = "SELECT username FROM users WHERE email='$email'";
        $res = mysqli_query($conn, $qTitle);
        if(mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $username = $row['username'];
        }else {
            setcookie('XassureUser', NULL, time()-3600, '/');
            echo "
                <script>
                    window.location.href = '../';
                </script>
            ";
        }
    }else {
        header('Location: ../signup/signup.html');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "Profile - {$username}"; ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/details.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body id="_y3">
    <div class="mainProf">
        <div class="profile-main">
            <div class="profile">
                <div id="<?php echo $username?>" class="username">
                    Hey😃 <?php echo $username?>
                </div>
                <hr>
                <div class="buttons">
                    <a href="./u/orders/" id='order'>
                        Orders
                    </a>
                    <a href="../cart/cart.php" id="cart">
                        Cart
                    </a>
                    <a href="./u/edit-profile.php" id="editP">
                        Edit Profile
                    </a>
                    <a href="./u/myaddress.php" id="address">
                        Edit address
                    </a>
                    <a href="../contact/contact.html" id="help">
                        Contact Us
                    </a>
                    <a href="../" id="Home">
                        Home
                    </a>
                </div>
            </div>
        </div>
        <div class="moreYouLike">
            <style>
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
                <hr>
                <h2 style="color: #12263a;">More you would like</h2>
                <br>
                <div class="more">

                    <?php 
                        $moreSqlQuery = "SELECT * FROM products ORDER BY RAND()";
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
                                                    <div style='padding:0 10px 5px 10px;' class='price'>\${$more['product_price']}</div>
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
        <br>
        <br>
        <div class="feedback">
            <div id="email-us" class="email-us">
                <h1 class="primary">Email Us.</h1>
                <form action="../connections/mailto.php" method="post" onsubmit="return validateForm()">
                    <input type="text" class="_i044d" id="_i044d" name="email-text" placeholder="Your suggetions goes here">
                    <input type="submit" name="submit" onclick="return validateForm()" id="email-submit">
                    <label for="email-submit" class="btn-email">
                        <img src="../resources/icons8-arrow.gif" alt="->">
                    </label>
                    <p id="emailSending" class="emailSending secondary"></p>
                </form>
                <script>
                    function validateForm() {
                        var emailSending =document.getElementById('emailSending');
                        var textField =document.getElementById('_i044d');
                        var text = textField.value.trim();

                        if(text === '') {
                            emailSending.textContent = 'Enter your suggetions to continue';
                            emailSending.style.color = 'red';
                            textField.style.border = '1px solid red';
                            return false;

                        }
                        emailSending.textContent = 'Sending email...';
                        return true; 
                    }
                    var emailSending =document.getElementById('emailSending');
                    var textField =document.getElementById('_i044d');
                    textField.addEventListener('input', ()=> {
                        textField.style.border = '2px solid #2d2c2c6e';
                        emailSending.textContent = '';
                        emailSending.style.color = ''
                    })
                </script>

                <p class="_c45 secondary">&copy; xfasso 2024</p>
            </div>
        </div>
    </div>
    
</body>
</html>

<?php 
    mysqli_close($conn);
?>
