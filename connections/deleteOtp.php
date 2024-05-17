<?php 
    error_reporting(0);

    date_default_timezone_set('Asia/Kolkata');
    $timeLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    $countQuery = "DELETE FROM otp WHERE time <= '$timeLimit'";
    $result = mysqli_query($conn, $countQuery);
        
?>