<?php 
    session_start();
    require '../../connections/productdb.php';

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
            $username = $row['username'];
            $email = $row['email'];
            $gender = $row['gender'];
        }
    }else {
        header('Location: ../../signup/signup.html');
    }

    if(isset($gender)) {
        if($gender == 'male') {
            setcookie('G-Xuoqa28so3kn', "$gender", time()+3600,'./edit-profile.php');
        }else if( $gender == "female") {
            setcookie('G-Xuoqa28so3kn', "$gender", time()+3600,'./edit-profile.php');
        }
    }else {
        $gender = 'male';
    }
    if(isset($_COOKIE['G-Xuoqa28so3kU'])) {
        if($_COOKIE['G-Xuoqa28so3kU'] == 'male') {
            setcookie('G-Xuoqa28so3kn', "male", time()+3600,'./edit-profile.php');
            setcookie('G-Xuoqa28so3kU', "", time()-3600,'./edit-profile.php');

            $upDateGnder = "UPDATE users SET gender = 'male' WHERE email = '$email'";
            $res = mysqli_query($conn, $upDateGnder);
        }
        if($_COOKIE['G-Xuoqa28so3kU'] == 'female') {
            setcookie('G-Xuoqa28so3kn', "female", time()+3600,'./edit-profile.php');
            setcookie('G-Xuoqa28so3kU', "", time()-3600,'./edit-profile.php');

            $upDateGnder = "UPDATE users SET gender = 'female' WHERE email = '$email'";
            $res = mysqli_query($conn, $upDateGnder);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit my profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="../../css/edit-profile.css">
    
</head>
<body>
    <div class="nav">
        <a href='../profile.php' class="back">
            <img src="../../resources/left-arrow.png" width="32px">
        </a>
    </div>
    <div class="main">
        <div class="userDP" id="userDP">
            <div style="cursor: pointer;" id="yu2">
                <div id="male" class="userImg" style="cursor: pointer;">
                    <img src="../../resources/male.png" alt="user profile of male">
                </div>
                <p id="_m1">or</p>
                <div id="female" class="userImg" style="cursor: pointer;">
                    <img src="../../resources/female.png" alt="user profile of female" >
                </div>
            </div>
            <script>
                var gender = document.getElementById('yu2');

                var male = document.getElementById('male');
                var female = document.getElementById('female');
                var msg = document.getElementById('_m1');
                
                var upDateGender = false;

                function getCookie(name) {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) return parts.pop().split(';').shift();
                }
                if(getCookie('G-Xuoqa28so3kn') === 'male') {
                    female.style.display = 'none';
                    msg.style.display = 'none';
                }
                if(getCookie('G-Xuoqa28so3kn') === 'female') {
                    male.style.display = 'none';
                    msg.style.display = 'none';
                }
                
                gender.addEventListener('click', () => {
                    male.style.display = 'block';
                    msg.style.display = 'block';
                    female.style.display = 'block';
                    gender.style.cursor = 'unset';
                    
                    var _ij3 =document.getElementById('_ij3');
                    _ij3.addEventListener('click', ()=> {
                        if(getCookie('G-Xuoqa28so3kn') === 'male') {
                            female.style.display = 'none';
                            msg.style.display = 'none';
                        }
                        if(getCookie('G-Xuoqa28so3kn') === 'female') {
                            male.style.display = 'none';
                            msg.style.display = 'none';
                        }
                    })

                    male.removeEventListener('click', maleClickHandler);
                    female.removeEventListener('click', femaleClickHandler);
       
                    male.addEventListener('click', maleClickHandler);
                    female.addEventListener('click', femaleClickHandler);
                });
                    
                function maleClickHandler() {
                    var cookieExpires = new Date(Date.now() + 1000 * 60 * 60).toUTCString();
                    document.cookie = "G-Xuoqa28so3kU=male; expires="+ cookieExpires +"; path=./edit-profile.php";
                    window.location.reload();

                }

                function femaleClickHandler() {
                    var cookieExpires = new Date(Date.now() + 1000 * 60 * 60).toUTCString();
                    document.cookie = "G-Xuoqa28so3kU=female; expires="+ cookieExpires +"; path=./edit-profile.php";
                    window.location.reload();
                }
            </script>
        </div>
        <hr>
        <div id="_ij3" class="_ij3">
            <div class="updateName">
                <h1 class="te">Your Name</h1>
                <form method="post">
                    <input class="inp" type="text" name='name' id='name' value="<?php echo $username; ?>">
                    <input class="bt" type="submit" name='submitName' value='submit'>
                </form>

                <?php 
                    if(isset($_POST['submitName'])) {
                        $username = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
                        $nameQ = "UPDATE users SET username='$username' WHERE email='$email'";
                        $nameR = mysqli_query($conn, $nameQ);
                        if(mysqli_affected_rows($conn) > 0) {
                            echo "<script>window.location.reload()</script>";
                        }
                    }
                ?>
            </div>
            <div class="updateEmail">
                <h1 class="te">Your Email</h1>
                <form method="post">
                    <input class="inp" type="text" name='email' id='email' value="<?php echo $email;?>">
                    <input class="bt" type="submit" name='submitEmail' id="emailSubmit" value='submit'>
                    <p id="warning" style="margin: 4px 0 0 1px; color: red; font-size: 14px;"></p>
                    <?php 

                        require '../../phpmailer/src/Exception.php';
                        require '../../phpmailer/src/PHPMailer.php';
                        require '../../phpmailer/src/SMTP.php';

                        use PHPMailer\PHPMailer\PHPMailer;
                        use PHPMailer\PHPMailer\Exception;
                        use PHPMailer\PHPMailer\SMTP;

                        if(isset($_POST['submitEmail'])) {
                            $emailUser = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                            if($emailUser == $email) {
                                
                            }else {
                                $userEQ = "SELECT * FROM users WHERE email='$emailUser'";
                                $res = mysqli_query($conn, $userEQ);
                                if(mysqli_num_rows($res) > 0) {
                                    echo "
                                        <script>
                                            var emailField = document.getElementById('email');
                                            var warning = document.getElementById('warning');
                                            emailField.style.borderBottom = '1px solid red';
                                            emailField.style.color = 'red';
                                            warning.innerHTML = 'user alredy exists';
                                            emailField.value = '$emailUser';
                                        </script>
                                    ";
                                }else {
                                    try { 
                        
                                        $digits = 6;
                                        $otpCode = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    
                                        $deleteTable = "DELETE FROM otp WHERE email ='$emailUser'";
        
                                        if(mysqli_query($conn, $deleteTable)) {
                                            $sqlOtpQuery = "INSERT INTO otp (email, otp) VALUES('$emailUser', '$otpCode');";
                                        }else {
                                            $sqlOtpQuery = "INSERT INTO otp (email, otp) VALUES('$emailUser', '$otpCode');";
                                        }
                                        $queryOtpRun = mysqli_query($conn, $sqlOtpQuery);
                    
                                        
                                        date_default_timezone_set("Asia/Kolkata");
                                        $date = date("d-m-Y h:i:s A");
                                        $message = "
                                            <head>
                                                <style>
                                                    *{
                                                        margin: 0;
                                                        padding: 0;
                                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                                    }
                                                </style>
                                            </head>
                    
                                            <div style='background: #fff; color: #000; padding: 3% 4%;'>
                                                <h3>Your otp to update email is:</h3>
                                                <br>
                                                <br>
                                                <h1>{$otpCode}</h1>
                                            </div>
                                        ";
                                        
                                        $mail = new PHPMailer(true);
                    
                                        $mail -> isSMTP();
                                        $mail->Host = 'smtp.gmail.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'xfassofashion@gmail.com';
                                        $mail->Password = 'efoovowwgtdoxrih';
                                        $mail->SMTPSecure = 'ssl';
                                        $mail->Port = 465;
                    
                                        $mail->setFrom('xfassofashion@gmail.com');
                    
                                        $mail->addAddress($emailUser);
                                        $mail->isHTML(true);
                                        $mail->Subject = "Update email varification code: {$otpCode}";
                                        $mail->Body = $message;
                                        $mail->send();     
                                        
                                    }
                                    catch(Exception) {
                                        echo "Try connecting to internet please!";
                                    }
            
                                    $_SESSION['emailUser'] = $emailUser;   
                                    echo "
                                        <input class='inp otp' type='text' name='otp' id='otp' value='' placeholder='Enter the otp'>
                                        <input class='bt' type='submit' name='submitOtp' value='submit'>
                                        <p id='warn'></p>
                                        <script>
                                            var email = document.getElementById('email');
                                            email.value = '$emailUser';
                                            var emailSub = document.getElementById('emailSubmit');
                                            emailSub.disabled = true;
                                            emailSub.style.display = 'none';
                                        </script>
                                    ";
                                }
                            }                        
                        }
                        if(isset($_POST['submitOtp'])) {
                            $emailUser = $_SESSION['emailUser'];
                            $otpEntered = filter_var($_POST['otp'], FILTER_SANITIZE_SPECIAL_CHARS);
                            $getOtpQ = "SELECT * FROM otp WHERE email='$emailUser'";
                            $otpR = mysqli_query($conn, $getOtpQ);
                            $res = mysqli_fetch_assoc($otpR);
                            $otpNew = $res["otp"];
                            if($otpEntered == $otpNew) {
                                $sql = "UPDATE users SET email='$emailUser' WHERE email='$email'";
                                $r = mysqli_query($conn, $sql);
                                //encrypt
                                $text = $emailUser;
                                //encrypting
                                $ciphering = "AES-128-CTR";
                                $iv_length = openssl_cipher_iv_length($ciphering);
                                $options = 0;
                                $encryption_iv = '1234567891021957';
                                $encryption_key = "xfassoKey";
                                $encrypted_id = openssl_encrypt($text, $ciphering, $encryption_key, $options, $encryption_iv);
                                $cookieExpires = time() + (365*24*60*60);
                                echo "
                                <script>
                                    document.cookie = 'XassureUser=$encrypted_id; expires='+ $cookieExpires +'; path=/';
                                    window.location.href = './edit-profile.php';
                                </script>
                                ";
                            }else {
                                echo"
                                    <script>
                                        var warning = document.getElementById('warning');
                                        warning.innerHTML = 'wrong otp try again';
                                        setTimeout(()=> {
                                            warning.innerHTML = '';
                                        }, 3500)
                                    </script>
                                ";
                            }
                        }
                    ?>
                    <script>
                    </script>
                </form>

                <div class="res">
                    <a href="../../reset/reset.php">reset password</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


<?php 
    mysqli_close($conn);
?>