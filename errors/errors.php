<?php 
 
   function isExisting(array $arr, $id) {
      $flag = 0;
   
      foreach($arr as $key => $value) {
         if($id == $value) {
            $flag = 1;
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
      echo $errorID;


      // find what error it is and redirect them to their own pages
      
   }else {
      echo "Error doesn't exist";
   }

 }else {
    echo"<script>
        window.location.href = '../'
    </script>";
 }
?>