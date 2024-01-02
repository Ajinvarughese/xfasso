<?php 
    session_start();
    require '../connections/productdb.php';

    if(isset($_POST['subPass'])) {
        $email = $_SESSION['email'];
        $password = $_POST['password'];
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $q = "UPDATE users SET password = '$hashedPass' WHERE email = '$email'";
        $result = mysqli_query($conn, $q);

                        
        //encrypt
        $text = $email;
        //encrypting
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891021957';
        $encryption_key = "xfassoKey";
        $encrypted_id = openssl_encrypt($text, $ciphering, $encryption_key, $options, $encryption_iv);

        setcookie("XassureUser", $encrypted_id, time() + (365*24*60*60),"/");
        header('Location: ../index.html');
        
    }else {
        header('Location: ../index.html'); //404 instead
    }
?>

<?php 
    mysqli_close($conn);
?>