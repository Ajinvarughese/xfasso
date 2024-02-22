<?php 
    require '../../connections/productdb.php';
    require './Ratings.php';

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
        }

    }else {
        header('Location: ../signup/signup.html');
    }

    if(isset($_POST["postRating"])) {
        $starCount = filter_var($_POST['starCount'], FILTER_SANITIZE_NUMBER_INT);
        $desc = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS); 
        $prodId = 6;
    
        $rating = new Ratings($prodId, $starCount, $user_id, $desc);

        
        $ratingObject = array(
                array(
                    "productID" => $rating->getProductID(),
                    "userID" => $rating->getUser(),
                    "starCount" => $rating->getCount(),
                    "description" => $rating->getDesc()
                
                )
            );
        $ratingJSON = json_encode($ratingObject);

        
        $fetchQ = "SELECT rating FROM products WHERE product_id = {$rating->product_id}";
        $result = mysqli_query($conn, $fetchQ);


        if (mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_assoc($result);
            if($row['rating'] == NULL) {
               $appendNewPost = "UPDATE products SET rating = '{$ratingJSON}' WHERE product_id = $prodId";
            }
            else {
                $remContent = substr_replace($row['rating'] ,"", -1);
                $ratingJSON = str_replace('[', " ",$ratingJSON); 
                $ratingJSONUpdate = $remContent.','.$ratingJSON;
                echo $ratingJSONUpdate;
                $appendNewPost = "UPDATE products SET rating = '{$ratingJSONUpdate}'  WHERE product_id = $prodId";
                
            }
            mysqli_query($conn, $appendNewPost);
        }
    }

    mysqli_close($conn);

    echo "
        <script>
            window.history.back();
        </script>
    ";
?>
