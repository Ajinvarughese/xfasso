<?php 
    function checkUserExistence($conn, $cookieEmail, $cookiePass) {
        if(isset($cookieEmail) && isset($cookiePass)) {

            $email = $cookieEmail;
            $pass = $cookiePass;

            function decrypting($text) {
                $ciphering = "AES-128-CTR";
                $options = 0;
                $decryption_iv = '1234567891021957';
                $decryption_key = "xfassoKey";
                $decrypted_id = openssl_decrypt($text, $ciphering, $decryption_key, $options, $decryption_iv);
                
                return $decrypted_id;
            }

            $emailId = decrypting($email);
            $passwordBeforeSplit = decrypting($pass);

            $splitPass = explode(' ', $passwordBeforeSplit);
            $password = $splitPass[0];

            $querFindUser = "SELECT * FROM users WHERE email='$emailId'";
            $runFindUser = mysqli_query($conn, $querFindUser);
            if(mysqli_num_rows($runFindUser)>0) {
                $resFindUser = mysqli_fetch_assoc($runFindUser);

                $passwordInDb = $resFindUser['password'];

                if(password_verify($password, $passwordInDb)) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
?>