<?php 
    require '../connections/productdb.php';
    if(isset($_COOKIE['XassureUser'])) {
        header('Location: ../');
    }
?>



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
            <div class="title">Welcome Back<span>.</span></div>
            <div class="p32k">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corrupti beatae ex modi at?
            </div>

            <div class="card" id='i22'>
            <form method="post" onsubmit="return validateForm()">
                    <h2>XFASSO</h2>
                    <div class="email">
                        <input type="email" name='email' id="email" placeholder="Email address" value="">
                        <p id="noEmail" style="color: red; font-size: 13px;"></p>
                    </div>
                    <div class="email">
                        <input type="password" style="font-weight: 900;" name='password' id="password" placeholder="Enter password" value="">
                        
                        <input type="checkbox" id="poqs" style="display: none;">
                        <label for="poqs" id="showPass">
                            <img id="imgPass" src="../resources/hidden.png" width="24px">
                        </label>
                        <script>
                            var pass = document.getElementById('password');
                            var hideShow =document.getElementById('imgPass');
                            var e = document.getElementById('poqs');
                            
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
                        <p id="noPass" style="color: red; font-size: 13px;"></p>
                    </div>
                    <div class="forgot" style='margin-top: 8px;'>
                        <a href="../reset/reset.php" style='font-size: 13px; color: #0062d1;'>Forgot password?</a>
                    </div>
                    <div class="getOtp" style='margin-top: 8px;'>
                        <input id="logIn" onclick="return validateForm()"  type="submit" name="logIn" value="Log In">
                    </div>
                    <div class="login">
                        <a href="../signup/signup.html">Create new account? Sign up</a>
                    </div>
                </form>
                <style>
                    #awf {
                        max-width: 192px;
                        text-align: center;
                        margin-bottom: 8px;
                    }
                    #awf img {
                        max-width: 100%;
                        max-height: 100%;
                        display: block;
                    }
                    .egg {
                        font-size: 12px;
                        opacity: 0.6;
                        margin-top: 10px;
                    }
                </style>
                <div id="awf"></div>
                <?php 
                    if(isset($_POST['logIn'])) {
                        $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                        $query = "SELECT * FROM users WHERE email='$email'";
                        $result = mysqli_query($conn, $query);

                        if(mysqli_num_rows($result)>0) {
                            $row = mysqli_fetch_assoc($result);
                            
                            if(password_verify($password, $row['password'])) {
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
                                echo "
                                    <script>
                                        var emailField = document.getElementById('email');
                                        emailField.value = '{$email}';
                                        var passField =document.getElementById('password');
                                        var noPassWarning =document.getElementById('noPass');

                                        noPassWarning.innerHTML = 'username or password must be wrong';
                                        passField.style.border = '1px solid red';
                                        emailField.style.border = '1px solid red';
                                    </script>
                                ";
                            }
                        }else {
                            echo "
                                <script>
                                    var emailField = document.getElementById('email');
                                    var noEmailWarning = document.getElementById('noEmail');

                                    noEmailWarning.innerHTML = 'user doesn\'t exists please sign up';
                                    emailField.style.border = '1px solid red';
                                </script>
                            ";
                        }
                    }
                ?>

                <div class="cpr">
                    <p class="_c45 secondary">&copy; xfasso 2024</p>
                </div>
            </div>

            <script>
                function getCookie(name) {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) return parts.pop().split(';').shift();
                }

                let egg = 0;
                function validateForm() {
                    var emailField = document.getElementById('email');
                    var noEmailWarning = document.getElementById('noEmail');
                    var email = emailField.value.trim(); 

                    var passField =document.getElementById('password');
                    var noPassWarning =document.getElementById('noPass');
                    var pass = passField.value.trim();

                    
                    if(email === '' || !/^.+@.+\..+$/.test(email)) {
                        noEmailWarning.innerHTML = 'Please enter a valid email address';
                        emailField.style.border = '1px solid red';
                        return false;
                    }

                    if (pass === '') {
                        noPassWarning.innerHTML = 'Please enter your password';
                        passField.style.border = '1px solid red';
                        return false;
                    }

                    if(pass === 'password') {
                        egg++;
                        passField.value = "";
                        noPassWarning.innerHTML = 'password is wrong';
                        passField.style.border = '1px solid red';

                        return false;
                    }
                    if(pass === 'wrong') {
                        if(egg == 1) {
                            egg++;
                            passField.value = "";
                            noPassWarning.innerHTML = 'wrong password, try again';
                            passField.style.border = '1px solid red';

                            return false;
                        }
                    }
                    if(pass === 'again') {
                        if(egg == 2) {
                            egg++;
                            passField.value = "";
                            noPassWarning.innerHTML = 'again later';
                            passField.style.border = '1px solid red';

                            return false;
                        }
                    }
                    if(pass === 'try again later') {
                        if(egg == 3) {
                            egg = 0;
                            passField.value = "";
                            let awf =document.getElementById('awf');
                            noPassWarning.innerHTML = "";
                            awf.innerHTML = `<img src='../resources/404.jpg'> <p class='egg'>you found a hidden feature.</p>`;
                            passField.style.border = '1px solid #0f203076';

                            return false;
                        }
                    }

                    
                    
                    noNameWarning.innerHTML = '';
                    noEmailWarning.innerHTML = '';

                    return true;
                }

                var emailField =document.getElementById('email');
                var noEmailWarning =document.getElementById('noEmail');

                var passField =document.getElementById('password');
                var noPassWarning =document.getElementById('noPass');

                emailField.addEventListener('input', ()=> {
                    noEmailWarning.innerHTML = '';
                    emailField.style.border = '1px solid #0f203076'
                });

                passField.addEventListener('input', ()=> {
                    noPassWarning.innerHTML = '';
                    passField.style.border = '1px solid #0f203076'
                });



            </script>
        </div>
    </div>
</body>
</html>

<?php 
    mysqli_close($conn);
?>