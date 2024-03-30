<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .erroMain {
            min-height: 80vh;
        }
        .errorBlock {
            border: 1px solid;
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-bottom: 4rem;
        }
        .image {
            border: 1px solid;
            padding: 71px 89px;
        }
        .errorContent > div {
            margin-top: 24px;
        }
        .issue {
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <div class="errorMain">
        <div class="errorBlock">
            <div class="errorContent">
                <div class="image">
                    a
                </div>
                <div class="issue">
                    <p >
                        The product you're looking for doens't exist anymore.
                    </p>
                </div>
            </div>
        </div>

        <div id="email-us" class="email-us">
            <h1 class="primary">Email Us.</h1>
            <form action="../../connections/mailto.php" method="post">
                <input type="text" class="_i044d" name="email-text" value="" required placeholder="Your suggetions goes here">
                <input type="submit" name="submit" onclick="emailSubmit()" id="email-submit">
                <label for="email-submit" class="btn-email">
                    <img src="../../resources/icons8-arrow.gif" alt="->">
                </label>
                <p id="emailSending" class="emailSending secondary"></p>
                <br>
                <br><br>
                <ul style="display: flex; justify-content: center;" class="new-nav-social-links">
                    <li>
                        <a href="#" class="_u2c">
                            <img src="../../resources/socialmedia/icons8-instagram-48.png" width="24px" alt="instagram">
                        </a>
                    </li>
                    <li><a href="#" class="_u2c">
                        <img src="../../resources/socialmedia/icons8-facebook-48.png" width="24px" alt="facebook">
                    </a></li>
                    <li><a href="#" class="_u2c">
                        <img src="../../resources/socialmedia/icons8-pinterest-48.png" width="24px" alt="pinterest">
                    </a></li>
                    <li><a href="#" class="_u2c">
                        <img src="../../resources/socialmedia/icons8-twitterx-50.png" width="24px" alt="twitter X">
                    </a></li>
                </ul>
            </form>
            <p class="_c45 secondary">&copy; xfasso 2024</p>
        </div>
    </div>
    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(";").shift();
        }

        var emailSending = document.getElementById("emailSending");
        function emailSubmit() {
            emailSending.textContent = "Sending email...";
            emailSending.style.display = "block";
        }

        if (getCookie("message-sent")) {
            emailSending.style.display = "block";
            emailSending.textContent = "email send succesfully...";
            setTimeout(() => {
                emailSending.style.display = "none";
                document.cookie =
                "message-sent=messageSentTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
            }, 4000);
        }

    </script>
</body>
</html>


<?php 

 function errorPage($errorID, $redirect = false) {
    if($errorID == 1052) {
        return ("
            <div>
        ");
    }
 }
?>