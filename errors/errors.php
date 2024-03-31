<?php 
   include './u/e.php';

   function title($errorID) {
      if($errorID == 1001) {
         echo "Can't find product";
      }else if($errorID == 1015) {
         echo "Email sending failed";
      }else if($errorID == 1025) {
         echo "Server Timeout";
      }
   }
   
   
   
   $errorName;

   function isExisting(array $arr, $id) {
      $flag = 0;
   
      foreach($arr as $key => $value) {
         if($id == $value) {
            $flag = 1;
            global $errorName;
            $errorName = $key;
            break;
         }
      }

      if($flag == 1) {
         return true;
      }else {
         return false;
      }
   }

   $existing_errors = 
   array(
      "product" => 1001,
      "email" => 1015,
      "dbFail" => 1025,
      "noPage" => 404
   );

 
 if(isset($_GET['errorID'])){
    
   $errorID = $_GET['errorID'];
   
   if(isExisting($existing_errors, $errorID)) {
      if($errorID == 1015 || $errorID == 404) {
         $content = errorPage($errorID, true);
      }
      else {
         $content = errorPage($errorID);
      }
   }else {
      echo"
         <script>
            window.location.href = './errors.php?errorID=404'
         </script>"
      ;
   }
 }else {
    echo"
      <script>
        window.location.href = './errors.php?errorID=404'
      </script>"
    ;
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php title($errorID); ?></title>

   <link rel="stylesheet" href="../css/style.css">

   <style>
      .erroMain {
         min-height: 80vh;
      }
      .errorBlock {
         min-height: 60vh;
         display: flex;
         align-items: center;
         justify-content: center;
         padding-bottom: 1rem;
      }
      .errorContent > div {
         margin-top: 24px;
         text-align: center;
      }
      .issue {
         opacity: 0.7;
      }
      .image {
         max-width: 367px;
         margin: 0 auto;
         display: block;
      }
      @media (max-width: 600px) {
         .image {
            max-width: 78%;
            max-height: 78%;
         }
      }
      .image img{
         max-width: 100%;
         max-height: 100%;
         display: block;
      }
      .errorContent > p {
         padding: 0 1.6rem;
      }
   </style>
</head>
<body>
   
   <?php 
     echo $content;
   ?>

   <hr style="width: 90%; margin:1.3rem auto;">
   <div id="email-us" class="email-us">
      <h1 class="primary">Email Us.</h1>
      <form action="../connections/mailto.php" method="post">
            <input type="text" id="sug" class="_i044d" name="email-text" value="" required placeholder="Your suggetions goes here">
            <input type="submit" name="submit" onclick="emailSubmit()" id="email-submit">
            <label for="email-submit" class="btn-email">
               <img src="../resources/icons8-arrow.gif" alt="->">
            </label>
            <p id="emailSending" class="emailSending secondary"></p>
            <br>
            <br><br>
            <ul style="display: flex; justify-content: center;" class="new-nav-social-links">
               <li>
                  <a href="#" class="_u2c">
                        <img src="../resources/socialmedia/icons8-instagram-48.png" width="24px" alt="instagram">
                  </a>
               </li>
               <li><a href="#" class="_u2c">
                  <img src="../resources/socialmedia/icons8-facebook-48.png" width="24px" alt="facebook">
               </a></li>
               <li><a href="#" class="_u2c">
                  <img src="../resources/socialmedia/icons8-pinterest-48.png" width="24px" alt="pinterest">
               </a></li>
               <li><a href="#" class="_u2c">
                  <img src="../resources/socialmedia/icons8-twitterx-50.png" width="24px" alt="twitter X">
               </a></li>
            </ul>
      </form>
      <p class="_c45 secondary">&copy; xfasso 2024</p>
   </div>
   <script>
      function getCookie(name) {
         const value = `; ${document.cookie}`;
         const parts = value.split(`; ${name}=`);
         if (parts.length === 2) return parts.pop().split(";").shift();
      }

      var emailSending = document.getElementById("emailSending");
      var sug =document.getElementById("sug");
      function emailSubmit() {
         emailSending.textContent = "Sending email...";
         emailSending.style.display = "block";
      }

      if (getCookie("message-sent")) {
         emailSending.style.display = "block";
         emailSending.textContent = "email send succesfully...";
         setTimeout(() => {
               emailSending.style.display = "none";
               sug.value = '';
               document.cookie =
               "message-sent=messageSentTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
         }, 4000);
      }

   </script>
</body>
</html>