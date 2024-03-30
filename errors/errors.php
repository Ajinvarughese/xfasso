<?php 

   function title($errorID) {
      if($errorID == 1052) {
         return "This is a big error";
      }else if($errorID == 1056) {
         return "This is second small error";
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
      "Error" => 1052,
      "Error2" => 1056
   );

 
 if(isset($_GET['errorID'])){
    
   $errorID = $_GET['errorID'];
   
   if(isExisting($existing_errors, $errorID)) {
      echo $errorID . '<br>';
      echo $errorName;
      
      // find what error it is and redirect them to their own pages
      
   }else {
      echo "Error doesn't exist redirect to 404";
   }
 }else {
    echo"<script>
        window.location.href = '../'
    </script>";
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo title($errorID); ?></title>
</head>
<body>
   
</body>
</html>