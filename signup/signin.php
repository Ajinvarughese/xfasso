<?php 
    if(isset($_COOKIE['XassureUser'])) {
        header('Location: ../index.html');
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
                    <h2 style='font-size: 20.3px;'>Enter OTP to continue</h2>
                    <div class='email'>
                        <input type='text' name='otpPass' id='otp' placeholder='Enter the OTP sent to your email'>
                        <p id='noOtp' style='color: red; font-size: 13px;'></p>
                    </div>
                    <div class='getOtp'>
                        <input type='submit' name='conOtp' value='Submit'>
                    </div>
                    <br>
                </form>
                <div style="opacity: 0.8; font-size: 12px;" class="cpr">
                    &copy; XFASSO 2023
                </div>
            </div>
        </div>
    <script>
        var first =document.getElementById('i22');
        var second =document.getElementById('i23');
        first.style.display = 'none';
    </script>

    <?php 
        session_start();
        require '../connections/productdb.php';
        
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';
        
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;
        if(isset($_POST['getOtp'])) {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            $queryCheckEmail = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $queryCheckEmail);

            if(mysqli_num_rows($result) > 0) {
                setcookie("exists", "email", time() + (60*60) ,"/");
                header('Location: ./signup.html');
            }else {

                $_SESSION['email'] = $email;
                $_SESSION['username']= $username;



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
                            <h3>Your otp is:</h3>
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
                    $mail->Subject = "Email varification code: {$otpCode}";
                    $mail->Body = $message;
                    $mail->send();
                            
                    $_POST['email'] = $email;
                    echo "
                    ";
                }
                catch(Exception) {
                    echo "Try connecting to internet please!";
                }
            }
        }        
        $email = $_SESSION['email'];

        $otpQuery = "SELECT email, otp FROM otp WHERE email = '$email'";
        $result = mysqli_query($conn, $otpQuery);
        $otp = mysqli_fetch_assoc($result);

        if(isset($_POST['conOtp'])) {
            $otpPass = filter_var($_POST['otpPass'], FILTER_VALIDATE_INT);
            if($email == $otp['email'] && $otpPass == $otp['otp']){
                header('Location: ./createPass.php');
            }else {
                echo"
                <script>
                    var otpField = document.getElementById('otp');
                    var noOtpWarning = document.getElementById('noOtp');
                    otpField.style.border ='1.4px solid red';
                    noOtpWarning.innerHTML = 'Wrong OTP. try again.';
                </script>
                ";
            }
        }
    ?>

    <script>
        var otpField = document.getElementById('otp');
        var noOtpWarning = document.getElementById('noOtp');
        function validateForm() {
            var otp = otpField.value.trim(); 
            if (otp === '') {
                noOtpWarning.innerHTML = 'Please enter the OTP';
                otpField.style.border ='1.4px solid red';
                return false;
            }

            noOtpWarning.innerHTML = '';
            return true;
        }
        otpField.addEventListener('input', ()=> {
            noOtpWarning.innerHTML = '';
            otpField.style.border ='1px solid #0f203076';
        })
    </script>
</body>
</html>

<?php 
    mysqli_close($conn);
?>