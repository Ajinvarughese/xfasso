<?php 
    require '../connections/productdb.php';
    require '../checkexistence/checkExistence.php';

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
        }

        $q = "SELECT * FROM cart_user WHERE user_id = '$user_id'";
        $runQ = mysqli_query($conn, $q);

        if(mysqli_num_rows($runQ) > 0) {
            $numOfProd = mysqli_num_rows($runQ);
            $cartNum = ["num" => $numOfProd];
            echo json_encode($cartNum);
        }else {
            echo"<script>window.history.back()</script>";
        }
    }else {
        $numOfProd = 0;
        header('Location: ../');
    }
?>
