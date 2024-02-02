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
        $prodId = 4;

        $rating = new Ratings($starCount, $user_id, $desc);

        $newRatingData = json_encode($rating);

        echo $newRatingData;

        $fetchQ = "SELECT rating FROM products WHERE product_id = {$prodId}";
        $result = mysqli_query($conn, $fetchQ);

        if (mysqli_fetch_assoc($result)) {
            $res = mysqli_fetch_assoc($result);
            $appendNewPost = "UPDATE products SET rating = JSON_ARRAY_APPEND(rating, '$', '{\"userId\": 4, \"starCount\": 2, \"description\": \"nice product\"}') WHERE product_id = 4";
        }
    }
?>
