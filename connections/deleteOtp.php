<?php 
    require './productdb.php';
    date_default_timezone_set('Asia/Kolkata');
    $timeLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    echo $timeLimit;
    $countQuery = "DELETE FROM otp WHERE time <= '$timeLimit'";
    $result = mysqli_query($conn, $countQuery);
        
    if(!$result) {
        echo "<br>Nothing to delete Now!";
        header("Location: ../shop/shop.php");
    }else {
        header("Location: ../shop/shop.php");
    }
?>