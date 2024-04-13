<?php  
    date_default_timezone_set('Asia/Kolkata');
    $time = date('m-d-Y h:i:s a', time());
    $device = $_SERVER['HTTP_USER_AGENT'];
    $logData  = array(
        array(
            'device' => $device,
            'time' => $time 
        )
    );

    $jsonLog = json_encode($logData);
    // add log data to db for next daY........ Good work mahnn!

    $remContent = substr_replace($ ,"", -1);
                $ratingJSON = str_replace('[', " ",$ratingJSON); 
                $ratingJSONUpdate = $remContent.','.$ratingJSON;
                echo $ratingJSONUpdate;
?>
