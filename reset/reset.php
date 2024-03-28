<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Let's sign up...</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       
    
    
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    
    <div class="container">
        <div class="card-right">
            <img src="../resources/4957136_4957136.jpg" alt="signup">
        </div>
        <div class="card-left">
            <div class="title">Reset Password<span>.</span></div>
            <div class="p32k">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corrupti beatae ex modi at?
            </div>

            <div class="card" id='i22'>
                <form id="em" method="post" onsubmit="return validateForm()">
                    <h2 style="font-size: 21px;">Enter your email</h2>
                    <div class="email">
                        <input type="email" name='email' id="email" placeholder="Email address" value="">
                        <p id="noEmail" style="color: red; font-size: 13px;"></p>
                    </div>
                    <div class="getOtp">
                        <input id="getOtp" onclick="return validateForm()"  type="submit" name="getOtp" value="Get OTP">
                    </div>
                    <div class="login">
                        <a href="../login/login.php">Don't want to change password?</a>
                    </div>
                </form>
                <?php 
                    session_start();

                    if(isset($_COOKIE['wrongOtp'])) {
                        echo "
                            <form id='ot' action='./checkOtp.php' method='post' onsubmit='return validateForm2()'>
                                <h2 style='font-size: 21px;'>Verify the OTP</h2>
                                <div class='email'>
                                    <input type='text' name='otp' id='otp' placeholder='OTP' value=''>
                                    <p id='noOtp' style='color: red; font-size: 13px;'></p>
                                </div>
                                <div style='margin-bottom: 1.2rem;' class='getOtp'>
                                    <input id='getOtp' onclick='return validateForm2()'  type='submit' name='subOtp' value='submit'>
                                </div>
                            </form>
                            <script>
                                var otpField =document.getElementById('otp');
                                var noOtp =document.getElementById('noOtp');
                                noOtp.innerHTML = 'wrong otp try again';
                                otpField.style.border = '1px solid red';

                                document.getElementById('em').style.display = 'none';
                                otpField.addEventListener('input', ()=> {
                                    noOtp.innerHTML = '';
                                    otpField.style.border = '1px solid #0f203076';
                                })
                            </script>
                        ";
                        setcookie('wrongOtp','', time()-3600,'/');
                    }
                    require '../connections/productdb.php';

                    require '../phpmailer/src/Exception.php';
                    require '../phpmailer/src/PHPMailer.php';
                    require '../phpmailer/src/SMTP.php';


                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\Exception;
                    use PHPMailer\PHPMailer\SMTP;
                    
                    if(isset($_POST['getOtp'])) {
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                        $_SESSION['email'] = $email;

                        $queryCheckEmail = "SELECT * FROM users WHERE email = '$email'";
                        $result = mysqli_query($conn, $queryCheckEmail);

                        if(mysqli_num_rows($result) > 0) {
        
                            try { 
                    
                                $digits = 6;
                                $otpCode = rand(pow(10, $digits-1), pow(10, $digits)-1);
            
                                $deleteTable = "DELETE FROM otp WHERE email ='$email'";

                                if(mysqli_query($conn, $deleteTable)) {
                                    $sqlOtpQuery = "INSERT INTO otp (email, otp) VALUES('$email', '$otpCode');";
                                }else {
                                    $sqlOtpQuery = "INSERT INTO otp (email, otp) VALUES('$email', '$otpCode');";
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
                                        <h3>Your otp to reset Password:</h3>
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
            
                                $mail->addAddress($email);
                                $mail->isHTML(true);
                                $mail->Subject = "Reset Password Email varification code: {$otpCode}";
                                $mail->Body = $message;
                                $mail->send();
                                        
                                $_POST['email'] = $email;
                                echo "
                                    <form id='ot' action='./checkOtp.php' method='post' onsubmit='return validateForm2()'>
                                        <h2 style='font-size: 21px;'>Verify the OTP</h2>
                                        <div class='email'>
                                            <input type='text' name='otp' id='otp' placeholder='OTP' value=''>
                                            <p id='noOtp' style='color: red; font-size: 13px;'></p>
                                        </div>
                                        <div style='margin-bottom: 1.2rem;' class='getOtp'>
                                            <input id='getOtp' onclick='return validateForm2()'  type='submit' name='subOtp' value='submit'>
                                        </div>
                                    </form>
                                    <script>
                                        document.getElementById('em').style.display = 'none';
                                        
                                        var otpField = document.getElementById('otp');
                                        var noOtp =document.getElementById('noOtp');
                                        
                                        otpField.addEventListener('input', ()=> {
                                            noOtp.innerHTML = '';
                                            otpField.style.border = '1px solid #0f203076';
                                        })
                                    </script>
                                ";
                            }
                            catch(Exception) {
                                echo "Try connecting to internet please!";
                            }

                            
                        }else {
                            echo "
                            <script>
                                var emailField =document.getElementById('email');
                                var noEmailWarning =document.getElementById('noEmail');

                                noEmailWarning.innerHTML = 'User doesn\'t exists please sign up';
                                emailField.style.border = '1px solid red';
                            </script>
                            ";
                        }

                    }
                    if(isset($_COOKIE['trueOtp'])) {
                        setcookie('trueOtp', '', time()-3600, '/');
                        echo "
                            <form id='re' action='./resetPass.php' method='post' onsubmit='return validateForm3()'>
                                <h2 style='font-size: 21px;'>Enter new password</h2>
                                <div class='email'>
                                    <input type='password' style='font-weight: 900;' name='password' id='password' placeholder='New password' value=''>
                                    <p id='noPass' style='color: red; font-size: 13px;'></p>
                                </div>
                                <div class='email'>
                                    <input type='password' style='font-weight: 900;' name='password2' id='password2' placeholder='Confirm password' value=''>
                                    <p id='noPass2' style='color: red; font-size: 13px;'></p>
                                </div>
                                <div style='margin-bottom: 1.2rem;' class='getOtp'>
                                    <input id='confirmPass' onclick='return validateForm3()'  type='submit' name='subPass' value='submit'>
                                </div>
                            </form>
                            <script>
                                document.getElementById('em').style.display = 'none';

                                var passField =document.getElementById('password');
                                var noPass =document.getElementById('noPass');
                                passField.addEventListener('input', ()=> {
                                    noPass.innerHTML = '';
                                    passField.style.border = '1px solid #0f203076';
                                })
                                var passField2 =document.getElementById('password2');
                                var noPass2 =document.getElementById('noPass2');
                                passField2.addEventListener('input', ()=> {
                                    passField2.style.border = '1px solid #0f203076';
                                    noPass2.innerHTML = '';
                                })

                            </script>
                        ";
                    }
                ?>
                <div class="cpr">
                    <p class="_c45 secondary">&copy; xfasso 2024</p>
                </div>
            </div>

            <script>

                function validateForm3() {
                    
                    var passField =document.getElementById('password');
                    var noPass =document.getElementById('noPass');
                    var pass = passField.value.trim();

                    var passField2 =document.getElementById('password2');
                    var noPass2 =document.getElementById('noPass2');
                    var pass2 = passField2.value.trim();

                    if(pass === '' || pass.length <=5) {
                        noPass.innerHTML = 'Password must contain atleast 6 characters';
                        passField.style.border = '1px solid red';
                        return false;
                    }
                    if(pass2 === '' || pass.length <=5) {
                        noPass2.innerHTML = 'Password doesn\'t match';
                        passField2.style.border = '1px solid red';
                        return false;
                    }


                    noPass.innerHTML = '';
                    noPass2.innerHTML = '';
                    return true;
                }
                function validateForm2() {
                
                    var otpField =document.getElementById('otp');
                    var noOtp =document.getElementById('noOtp');
                    var otp = otpField.value.trim();

                    if(otp === '') {
                        noOtp.innerHTML = 'Please enter a valid email address';
                        otpField.style.border = '1px solid red';
                        return false;
                    }
                    
                    noOtp.innerHTML = '';

                    return true;
                }
            </script>

            <script>

                function getCookie(name) {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) return parts.pop().split(';').shift();
                }
                function validateForm() {
                
                    var emailField =document.getElementById('email');
                    var noEmailWarning =document.getElementById('noEmail');
                    var email = emailField.value.trim();

                    if(email === '' || !/^.+@.+\..+$/.test(email)) {
                        noEmailWarning.innerHTML = 'Please enter a valid email address';
                        emailField.style.border = '1px solid red';
                        return false;
                        
                    }
                    
                    noEmailWarning.innerHTML = '';

                    return true;
                }

                var emailField =document.getElementById('email');
                var noEmailWarning =document.getElementById('noEmail');

                emailField.addEventListener('input', ()=> {
                    noEmailWarning.innerHTML = '';
                    emailField.style.border = '1px solid #0f203076';
                });
            </script>


        </div>
    </div>
</body>
</html>

<?php 
    mysqli_close($conn);
?>
