<?php 

function getUser($userID) {

    $emailId = $userID;

    //decrypting
    $ciphering = "AES-128-CTR";
    $options = 0;
    $decryption_iv = '1234567891021957';
    $decryption_key = "xfassoKey";
    $decrypted_id = openssl_decrypt($emailId, $ciphering, $decryption_key, $options, $decryption_iv);
    $email = $decrypted_id;

    $qTitle = "SELECT username FROM users WHERE email='$email'";
    $res = mysqli_query($conn, $qTitle);
    if(mysqli_num_rows($res) < 0) {
        echo "HEYYYYYY";
        // header('Location: ../signup/signup.html');
    }

}

?>