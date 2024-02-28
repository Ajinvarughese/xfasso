<?php 
    session_start();
    require('../connections/productdb.php');
    
    function product_to_cart() {
        require('../connections/productdb.php');
        if(isset($_COOKIE['XassureUser'])) {
            $emailId = $_COOKIE['XassureUser'];
    
            //decrypting
            $ciphering = "AES-128-CTR";
            $options = 0;
            $decryption_iv = '1234567891021957';
            $decryption_key = "xfassoKey";
            $decryptedEmail_id = openssl_decrypt($emailId, $ciphering, $decryption_key, $options, $decryption_iv);
            $email = $decryptedEmail_id;
    
            $qTitle = "SELECT * FROM users WHERE email='$email'";
            $res = mysqli_query($conn, $qTitle);
            if(mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_array($res);
                $email = $row['email'];
                $userId = $row['user_id'];
            }
        }else {
            header('Location: ../signup/signup.html');
        }

        if(isset($_COOKIE['ikwnquuS19'])) {
            $size = 'S';
        }
        if(isset($_COOKIE['ikwnquuM19'])) {
            $size = 'M';   
        }
        if(isset($_COOKIE['ikwnquuL19'])) {
            $size = 'L';
        }
        if(isset($_COOKIE['ikwnquuXL19'])) {
            $size = 'XL';
        }
        if(isset($_COOKIE['ikwnquuXXL19'])) {
            $size = 'XXL';
        }


        $product_id = $_COOKIE['productId'];

        $ciphering = "AES-128-CTR";
        $options = 0;
    
        //decrypting
        $decryption_iv = '1234567891021957';
        $decryption_key = "xfassoKey";
        $decrypted_id = openssl_decrypt($product_id, $ciphering, $decryption_key, $options, $decryption_iv);  
        
        $splitId = explode(' ', $decrypted_id);

        $decrypted_id = $splitId[1]; 

        $quantity = $_COOKIE['quantity']; 

        
        $checkInCart = "SELECT * FROM cart_user WHERE cart_product= $decrypted_id AND user_id=$userId";
        $runCheckQ = mysqli_query($conn, $checkInCart);

        if(mysqli_num_rows($runCheckQ) > 0) {
            $newQuery = "SELECT * FROM cart_user WHERE cart_product=$decrypted_id AND user_id=$userId AND size='$size'";
            $newRun = mysqli_query($conn, $newQuery);
            if(mysqli_num_rows($newRun) > 0) {
                $getDetails = mysqli_fetch_assoc($newRun);
        

                $sizeColumn = $getDetails['size'];
                $quantityExist = $getDetails['quantity'];
                $pId = $getDetails['cart_product'];
                $SI_NO = $getDetails['SI_NO'];

                $newQuantity = $quantity + $quantityExist;
                if($newQuantity <6) {
                    $updateQ = "UPDATE cart_user SET quantity=$newQuantity WHERE SI_NO=$SI_NO";
                    mysqli_query($conn, $updateQ);
                }else {
                    $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                    .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'); 
                    shuffle($seed); 
                    $rand = '';
                    foreach (array_rand($seed, 24) as $k) $rand .= $seed[$k];
                    setcookie('SESSIONQEND', $rand, time()+3600, '/');
                    echo "
                    <script>
                        window.location.href = '../details/details.php?productId={$product_id}'
                    </script>";
                }
            }else {
                $product_id = $_COOKIE['productId'];

                $ciphering = "AES-128-CTR";
                $options = 0;
            
                //decrypting
                $decryption_iv = '1234567891021957';
                $decryption_key = "xfassoKey";
                $decrypted_id = openssl_decrypt($product_id, $ciphering, $decryption_key, $options, $decryption_iv);  
                
                $splitId = explode(' ', $decrypted_id);

                $decrypted_id = $splitId[1]; 

                $q = "INSERT INTO cart_user(user_id, cart_product, quantity, size) VALUES($userId, $decrypted_id, $quantity, '$size')";
                mysqli_query($conn, $q);
            }   

        }else {
            $product_id = $_COOKIE['productId'];

            $ciphering = "AES-128-CTR";
            $options = 0;
        
            //decrypting
            $decryption_iv = '1234567891021957';
            $decryption_key = "xfassoKey";
            $decrypted_id = openssl_decrypt($product_id, $ciphering, $decryption_key, $options, $decryption_iv);  
            
            $splitId = explode(' ', $decrypted_id);

            $decrypted_id = $splitId[1]; 
            $q = "INSERT INTO cart_user(user_id, cart_product, quantity, size) VALUES($userId, $decrypted_id, $quantity, '$size')";
            $r = mysqli_query($conn, $q);
        }
    }

    if(isset($_POST['addCa'])) {  
        product_to_cart();

        if(isset($_COOKIE['ikwnquuS19'])) {
            setcookie('ikwnquuS19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuM19'])) {
            setcookie('ikwnquuM19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuL19'])) {
            setcookie('ikwnquuL19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuXL19'])) {
            setcookie('ikwnquuXL19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuXXL19'])) {
            setcookie('ikwnquuXXL19', '', time()-3600, '/');
        }

        setcookie('quantity', '', time()-3600, '/');
        setcookie('productId', '', time()-3600, '/');

        echo "<script>window.location.href = '../cart/cart.php'</script>";
    }else if(isset($_POST['buyNow'])) {
        product_to_cart();

        
        $product_id = $_COOKIE['productId'];

        $ciphering = "AES-128-CTR";
        $options = 0;
    
        //decrypting
        $decryption_iv = '1234567891021957';
        $decryption_key = "xfassoKey";
        $decrypted_id = openssl_decrypt($product_id, $ciphering, $decryption_key, $options, $decryption_iv);  
        
        $splitId = explode(' ', $decrypted_id);

        $decrypted_id = $splitId[1]; 
        
        setcookie('productId', '', time()-3600, '/');

        if(isset($_COOKIE['ikwnquuS19'])) {
            $size = 'S';
            setcookie('ikwnquuS19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuM19'])) {
            $size = 'M';
            setcookie('ikwnquuM19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuL19'])) {
            $size = 'L';
            setcookie('ikwnquuL19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuXL19'])) {
            $size = 'XL';
            setcookie('ikwnquuXL19', '', time()-3600, '/');
        }
        if(isset($_COOKIE['ikwnquuXXL19'])) {
            $size = 'XXL';
            setcookie('ikwnquuXXL19', '', time()-3600, '/');
        }

        setcookie('Xz-6fg4j', $size, time()+3600*24, '/');

        $_SESSION['newCheckoutProduct'] =  $decrypted_id;
        echo "<script>window.location.href = '../checkout/checkout.php'</script>";
    }
    else {
        header('Location: ../index.html');
    }
?>