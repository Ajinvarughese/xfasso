<?php 
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
            if($row['address']) {
                $addressJson = $row['address'];
                $addressData = json_decode($addressJson);
                $fullName = $addressData->fullName;
                $phone = $addressData->phone;
                $altPhone = $addressData->altPhone;
                $pinCode = $addressData->pinCode;
                $state = $addressData->state;
                $city = $addressData->city;
                $address = $addressData->address;
                $place = $addressData->place;
                $landmark = $addressData->landmark;

                $nullAdd = false;
            }else {
                $fullName = "";
                $phone = "";
                $altPhone = "";
                $pinCode = "";
                $state = "";
                $city = "";
                $address = "";
                $place = "";
                $landmark = "";

                $nullAdd= true;
                  
            }
        }
    }else {
        header('Location: ../../signup/signup.html');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $username;?> address</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       


    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
            color: #12263a;
        }
        html {
            scroll-behavior: smooth;
        }
        .main {
            min-height: 70vh;
            padding: 14px 0 1.5rem 0;
        }
        form {
            min-height: 70vh;
            width: 70%;
            margin: 0 auto;
            max-width: 480px;
        }
        .nameNnum, .ap {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .nameNnum input, .cityD input, .ap input {
            padding: 14.6px 10.2px;
            width: 100%;
            font-size: 15px;
            border: 1px solid #0f203076;
            border-radius: 3px;
            outline: none;
        }
        .nameNnum input:focus, .cityD input:focus, .ap input:focus {
            border: 1.5px solid #12263a;
        }
        .cityD {
            display: grid;
            grid-template-columns: auto auto;
            gap: 0.6rem 2%;
        }
        .cityD, .ap, #submit {
            margin-top: 0.6rem;
        }
        #submit, #dlt {
            width: 100%;
            padding: 14px 0;
            background: #12263a;
            border: none;
            color: #fff;
            font-weight: 500;
            border-radius: 3px;
            cursor: pointer;
        }
        .qo3ob {
            text-align: center;
            padding-top: 0.9rem;
        }
        #adr {
            text-align: center;
            padding-bottom: 0.4rem;
        }
        @media (max-width: 570px) {
            form {
                width: 90%;
            }
        }

        .nav {
            position: relative;
            min-height: 3.7rem;
            height: 8vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            box-shadow: 0 2px 10px #0f203076;
            background: #12263a;
        }
        .nav img {
            width: 34px;
            transition: 0.2s ease;
        }
        .nav img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="nav">
        <div style="cursor: pointer;" id="back" class="back">
            <img src="../../resources/left-arrow.png" width="32px">
        </div>
        <script>
            let back =document.getElementById('back');
            back.addEventListener('click', ()=> {
                window.history.back();
            })
        </script>
        <a style="color: white;" href="./edit-profile.php">
            <img src="../../resources/user.png" alt="profile">
        </a>
    </div>
    <div class="main">
        <h1 class='qo3ob'>Create address</h1>
        <form method="post" onsubmit="return validateForm()">
            <div class="nameNnum">
                <div class="n">
                    <input type="text" id="username" name='name' value="<?php echo $fullName?>" placeholder="Full name (Required)*">
                    <p id="noName" style="color: red; font-size: 13px;"></p>
                </div>
                <div class="p">
                    <input type="tel" id="phone" name='phone' value="<?php echo $phone?>" placeholder="Phone number (Required)*">
                    <p id="noPhone" style="color: red; font-size: 13px;"></p>    
                </div>
                <input type="tel" id="phone2" name="phone2" value="<?php echo $altPhone?>" placeholder="Alternative phone number (Optional)">
            </div>
            <div class="cityD">
                <div class="pi">
                    <input type="text" id="pincode" name='pincode' value="<?php echo $pinCode?>" placeholder="Pincode (Required)*">
                    <p id="noPinCode" style="color: red; font-size: 13px;"></p>    
                </div>
                <div class="st">
                    <input type="text" id="state" name="state" value="<?php echo $state?>" placeholder="State (Required)*">
                    <p id="noState" style="color: red; font-size: 13px;"></p>
                </div>
                <div class="ci">
                    <input type="text" id="city" name="city" value="<?php echo $city?>" placeholder="City (Required)*">
                    <p id="noCity" style="color: red; font-size: 13px;"></p>
                </div>
            </div>
            <div class="ap">
                <div class="ad">
                    <input type="text" id="address" name="address" value="<?php echo $address?>" placeholder="House No, Your address (Required)*">
                    <p id="noAddress" style="color: red; font-size: 13px;"></p>
                </div>
                <div class="pl">
                    <input type="text" id="place" name="place" value="<?php echo $place?>" placeholder="Road name, Area, Colony (Required)*">
                    <p id="noPlace" style="color: red; font-size: 13px;"></p>    
                </div>
                <input type="text" id="landmark" name="landmark" value="<?php echo $landmark?>" placeholder="Land mark (Optional)">
            </div>
            <input id="submit" name="save" onclick="return validateForm()" type="submit" value="Save Address">
            <input id="dlt" style="margin-top: 0.5rem; background:none; color: inherit; font-weight: 600; border: 1px solid #12263a;"  type="submit" name="dltAdd" value="Delete Address">
        </form>

        <script>
            function validateForm() {
                // Name 
                var nameField = document.getElementById('username');
                var noNameWarning = document.getElementById('noName');
                var name = nameField.value.trim(); 

                // Phone
                var phoneField =document.getElementById('phone');
                var noPhoneWarning =document.getElementById('noPhone');
                var phone = phoneField.value.trim();

                //pincode 
                var pincodeField =document.getElementById('pincode');
                var noPinWarning =document.getElementById('noPinCode');
                var pincode = pincodeField.value.trim();

                //state
                var stateField =document.getElementById('state');
                var noStateWarning =document.getElementById('noState');
                var state = stateField.value.trim();

                //city 
                var cityField = document.getElementById('city');
                var noCityWarning = document.getElementById('noCity');
                var city = cityField.value.trim(); 

                //address
                var addressField = document.getElementById('address');
                var noAddressWarning = document.getElementById('noAddress');
                var address = addressField.value.trim(); 

                //place
                var placeField = document.getElementById('place');
                var noPlaceWarning = document.getElementById('noPlace');
                var place = placeField.value.trim(); 

                
                if (name === '') {
                    noNameWarning.innerHTML = 'Please enter your full name';
                    nameField.style.border = '1px solid red';
                    return false;
                }
                if(phone === '') {
                    noPhoneWarning.innerHTML = 'Please enter your mobile number';
                    phoneField.style.border = '1px solid red';
                    return false; 
                }
                if(pincode === '') {
                    noPinWarning.innerHTML = 'Please enter the pincode';
                    pincodeField.style.border = '1px solid red';
                    return false; 
                }
                if(state === '') {
                    noStateWarning.innerHTML = 'Please enter your state';
                    stateField.style.border = '1px solid red';
                    return false;
                }
                if(city === '') {
                    noCityWarning.innerHTML = 'Please enter your city';
                    cityField.style.border = '1px solid red';
                    return false;
                }
                if(address === '') {
                    noAddressWarning.innerHTML = 'Please enter your address';
                    addressField.style.border = '1px solid red';
                    return false;
                }
                if(place === '') {
                    noPlaceWarning.innerHTML = 'Please enter your place';
                    placeField.style.border = '1px solid red';
                    return false;
                }

                noNameWarning.innerHTML = '';
                noPhoneWarning.innerHTML = '';
                noPinWarning.innerHTML = '';
                noStateWarning.innerHTML = '';
                noCityWarning.innerHTML = '';
                noAddressWarning.innerHTML = '';
                noPlaceWarning.innerHTML = '';
                return true;
            }

            //Name
            var nameField = document.getElementById('username');
            var noNameWarning = document.getElementById('noName');
                
            // Phone
            var phoneField =document.getElementById('phone');
            var noPhoneWarning =document.getElementById('noPhone');
            

            //pincode 
            var pincodeField =document.getElementById('pincode');
            var noPinWarning =document.getElementById('noPinCode');
            

            //state
            var stateField =document.getElementById('state');
            var noStateWarning =document.getElementById('noState');
            

            //city 
            var cityField = document.getElementById('city');
            var noCityWarning = document.getElementById('noCity');
        

            //address
            var addressField = document.getElementById('address');
            var noAddressWarning = document.getElementById('noAddress');
        

            //place
            var placeField = document.getElementById('place');
            var noPlaceWarning = document.getElementById('noPlace');

            nameField.addEventListener('input', ()=> {
                nameField.style.border = '1.5px solid #0f203076';
                noNameWarning.innerHTML = '';
            });

            phoneField.addEventListener('input', ()=> {
                phoneField.style.border = '1.5px solid #0f203076';
                noPhoneWarning.innerHTML = '';
            });

            pincodeField.addEventListener('input', ()=> {
                pincodeField.style.border = '1.5px solid #0f203076';
                noPinWarning.innerHTML = '';
            });

            stateField.addEventListener('input', ()=> {
                stateField.style.border = '1.5px solid #0f203076';
                noStateWarning.innerHTML = '';
            });

            cityField.addEventListener('input', ()=> {
                cityField.style.border = '1.5px solid #0f203076';
                noCityWarning.innerHTML = '';
            });

            addressField.addEventListener('input', ()=> {
                addressField.style.border = '1.5px solid #0f203076';
                noAddressWarning.innerHTML = '';
            });

            placeField.addEventListener('input', ()=> {
                placeField.style.border = '1.5px solid #0f203076';
                noPlaceWarning.innerHTML = '';
            });
                
        </script>
    </div>
</body>
</html>

<?php 

    if(isset($_POST['save'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS);
        $phone2 = "";
        
        $pincode = filter_var($_POST['pincode'], FILTER_SANITIZE_SPECIAL_CHARS);
        $state = filter_var($_POST['state'], FILTER_SANITIZE_SPECIAL_CHARS);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_SPECIAL_CHARS);
        
        $address = filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS);
        $place = filter_var($_POST['place'], FILTER_SANITIZE_SPECIAL_CHARS);
        $landmark = "";

        if(isset($_POST['phone2'])) {
            $phone2 = filter_var($_POST['phone2'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        if(isset($_POST['landmark'])) {
            $landmark = filter_var($_POST['landmark'], FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $addQ = "UPDATE users SET address = '{
            \"fullName\": \"$name\",
            \"phone\": \"$phone\",
            \"altPhone\": \"$phone2\",
            \"pinCode\": \"$pincode\",
            \"state\": \"$state\",
            \"city\": \"$city\",
            \"address\": \"$address\",
            \"place\": \"$place\",
            \"landmark\": \"$landmark\"
        }' WHERE email = '$email';";
        
        $res = mysqli_query($conn, $addQ);        
        echo "<script>window.location.href='./myaddress.php'</script>";
    }

    if(isset($_POST['dltAdd'])) {
        $dltAddQ = "UPDATE users SET address = NULL WHERE email='$email';";
        try {
            mysqli_query($conn, $dltAddQ);
            echo "<script>
                window.location.href = './myaddress.php';
            </script>";
        }catch(mysqli_sql_exception) {

        }
    }
?>

<?php 
    mysqli_close($conn);
?>