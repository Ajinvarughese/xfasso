<?php 
    session_start();
    if(isset($_COOKIE['XassureUser'])) {
        header('Location: ../');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <div class="container">
        <div class="card-right">
            <img src="../resources/4957136_4957136.jpg" alt="signup">
        </div>
        <div class="card-left">
            <div class="title">Sign Up<span>.</span></div>
            <div class="p32k">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corrupti beatae ex modi at?
            </div>

            <div class='card' id='i23'>
                <form method='post' onsubmit='return validateForm()'>
                    <h2 style='font-size: 20.3px;'>Create a password</h2>
                    <div class='email'>
                        <input type='password' style="font-weight: 900;" name='password' id='pass' placeholder='Create a password'>

                        <input type="checkbox" id="_aWs" style="display: none;">
                        <label for="_aWs" id="_aWaswf">
                            <img id="_aqnwq" src="../resources/hidden.png" width="24px">
                        </label>
                        <script>
                            var pass = document.getElementById('pass');
                            var hideShow =document.getElementById('_aqnwq');
                            var e = document.getElementById('_aWs');
                            
                            e.addEventListener('change', ()=> {
                                if(pass.type === 'password') {
                                    pass.type = 'text';
                                    pass.style.fontWeight = '400';
                                    hideShow.src = '../resources/eye.png';
                                }else {
                                    pass.type = 'password';
                                    pass.style.fontWeight = '900';
                                    hideShow.src = '../resources/hidden.png';
                                }
                            })
                            
                        </script>
                        <p id='noOtp' style='color: red; font-size: 13px;'></p>
                    </div>
                    <div class='email'>
                        <input type='password' style="font-weight: 900;" name='conPass' id='conPass' placeholder='Confirm the password'>
                        <p id='noConPass' style='color: red; font-size: 13px;'></p>
                    </div>
                    <div class='getOtp'>
                        <input type='submit' name='submitPass' value='Submit'>
                    </div>
                    <br>
                </form>
                <div style="opacity: 0.8; font-size: 12px;" class="cpr">
                    <p class="_c45 secondary">&copy; xfasso 2024</p>
                </div>
            </div>

        </div>
    <script>
        var first =document.getElementById('i22');
        var second =document.getElementById('i23');
        first.style.display = 'none';
    </script>

    <?php 
        require '../connections/productdb.php';
        
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';
        
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;

        if(isset($_POST['submitPass'])) {
            $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
            $conPass = filter_var($_POST['conPass'], FILTER_SANITIZE_SPECIAL_CHARS);
    
            if(strlen($password)<=5) {
                echo "
                <script>
                    var otpField = document.getElementById('otp');
                    var noOtpWarning = document.getElementById('noOtp');
            
                    noOtpWarning.innerHTML = 'Password must contain atleast 6 characters';
                    otpField.style.border ='1px solid red';
                    
                    otpField.addEventListener('input', ()=> {
                        noOtpWarning.innerHTML = '';
                        otpField.style.border ='1px solid #0f203076';
                    })
                </script>";
            }else {
                if($password == $conPass) {
                    if(isset($_SESSION['email']) && isset($_SESSION['username'])) {
                        $email = $_SESSION['email'];
                        $username = $_SESSION['username'];
                    }else {
                        header('Location: ../signup/signup.html');
                    }
                    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO users (username, email, password, gender) VALUES('$username', '$email', '$hashedPass', 'male')";
                    
                    $queryAlredy = "SELECT * FROM users WHERE email='$email'";
                    $result = mysqli_query($conn, $queryAlredy);
                    if(mysqli_num_rows($result)>0) {
                        header('Location: ../index.html');
                    }else {
                        $result = mysqli_query($conn, $query);
                        
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
                        
                    }
                    
                    
                }else {
                    echo "
                    <script>
                        var conPassField =document.getElementById('conPass');
                        var noConPassWarning =document.getElementById('noConPass');
                
                        noConPassWarning.innerHTML = 'Password doesn\'t match';
                        conPassField.style.border ='1.4px solid red';
                        
                        conPassField.addEventListener('input', ()=> {
                            noConPassWarning.innerHTML = '';
                            conPassField.style.border ='1px solid #0f203076';
                        })
                    </script>
                    ";
                }
            }
        }
    ?>


    <script>
        var otpField = document.getElementById('otp');
        var noOtpWarning = document.getElementById('noOtp');

        var conPassField =document.getElementById("conPass");
        var noConPassWarning =document.getElementById('noConPass');

        function validateForm() {
            var otp = otpField.value.trim(); 
            var conPass =conPassField.value.trim();
            if (otp === '') {
                noOtpWarning.innerHTML = 'Please create a password';
                otpField.style.border ='1.4px solid red';
                return false;
            }
            if(conPass === '') {
                noConPassWarning.innerHTML = 'Please confirm the password';
                conPassField.style.border ='1.4px solid red';
                return false;
            }
            
            noConPassWarning.innerHTML = '';
            noOtpWarning.innerHTML = '';
            return true;
        }
        otpField.addEventListener('input', ()=> {
            noOtpWarning.innerHTML = '';
            otpField.style.border ='1px solid #0f203076';
        })
        conPassField.addEventListener('input', ()=> {
            noConPassWarning.innerHTML = '';
            conPassField.style.border ='1px solid #0f203076';
        })
    </script>
</body>
</html>

<?php 
    mysqli_close($conn);
?>