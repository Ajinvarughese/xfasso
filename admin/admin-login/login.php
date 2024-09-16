<?php 
    
    require_once('../../connections/productdb.php');
    require '../../checkexistence/checkExistence.php';
    session_start();


    function countSpy() {
        if(empty($_SESSION['tryCount'])) {
            $_SESSION['tryCount'] = 0;
        }            
        $_SESSION['tryCount']++;

        if($_SESSION['tryCount']>=4) {
            echo "You've tried enough now wait in this page for 30seconds";
            if(empty($_COOKIE['timerEnd'])) {
                setcookie("startCount", "true", time()+3600, '/');
            }
        }else {
            setcookie('wrong', 'true', time()+3600, '/');
            header('location: ./');
        }
    }

    if(isset($_COOKIE['timerEnd'])) {
        $_SESSION['tryCount'] = 0;
        setcookie('timerEnd', NULL, time()-3600, '/');
        header('location: ./');
    }

    if(isset($_COOKIE['XassureUser'])) {
        $emailId = mysqli_escape_string($conn, $_COOKIE['XassureUser']);
        $cookiePassword = mysqli_escape_string($conn, $_COOKIE['X9wsWsw32']);

        if(checkUserExistence($conn, $emailId, $cookiePassword) == false) {
            header('Location: ../errors/errors.php?errorID=404');
        }

        //decrypting
        $ciphering = "AES-128-CTR";
        $options = 0;
        $decryption_iv = '1234567891021957';
        $decryption_key = "xfassoKey";
        $decrypted_id = openssl_decrypt($emailId, $ciphering, $decryption_key, $options, $decryption_iv);
        $email = $decrypted_id;

        $qTitle = "SELECT email FROM admin WHERE email='$email'";
        $res = mysqli_query($conn, $qTitle);
        if(mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $username = $row['username'];
        }else {
            echo "
                <script>
                    window.location.href = '../errors/errors.php?errorID=404';
                </script>
            ";
        }
    }else {
        header('Location: ../errors/errors.php?errorID=404');
    }

    if(isset($_POST['submit'])) {
        $adm_id = mysqli_real_escape_string($conn, $_POST['id']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $setIt = "SELECT admin_id, password, log_data FROM admin WHERE admin_id = '$adm_id'";
        $getIt = mysqli_query($conn, $setIt);

        if(mysqli_num_rows($getIt)>0) {
            $row = mysqli_fetch_assoc($getIt);
            if(password_verify($password, $row['password'])) {
                date_default_timezone_set('Asia/Kolkata');
                $time = date('m/d/Y h:i:s a', time());
                $device = $_SERVER['HTTP_USER_AGENT'];
                $logData  = array(
                    array(
                        'device' => $device,
                        'time' => $time 
                    )
                );
                $jsonLog = json_encode($logData);

                $jsonData = $row['log_data'];

                if($jsonData) {
                    $remContent = substr_replace($jsonData, "", -1);
                    $jsonLog = str_replace(array('[',']'), '', $jsonLog); 
                    $ratingJSONUpdate = $remContent . ',' . $jsonLog.']';
                }
                else {
                    $ratingJSONUpdate = $jsonLog;
                }

                $updateQuery = "UPDATE admin SET log_data='$ratingJSONUpdate' WHERE admin_id='$adm_id'";
                mysqli_query($conn, $updateQuery);

                $_SESSION['XQCLANG'] = $adm_id;
                echo "
                    <script>
                        window.location.href = '../admin.php';
                    </script>
                ";
            }else {
               countSpy();
            }
        }else {
            countSpy();
        }
    }else {
        echo "
            <script>
                window.location.href ='./';
            </script>
        ";
    }

    mysqli_close($conn);
?>

<div id='timer'></div>
<script>        
    function waiting() {
        var seconds = 30;
        var cookieExpires = new Date(Date.now() + 60 * 60 * 1000).toUTCString();
        var countdown = setInterval(function() {
            document.getElementById('timer').innerHTML = 'Seconds remaining: ' + seconds;
            seconds--;
            if (seconds < 0) {
                clearInterval(countdown);
                document.getElementById('timer').innerHTML = 'Countdown complete!';
                document.cookie = 'timerEnd=true; expires='+cookieExpires+'; path=/';
                window.location.reload();
            }
        }, 1000);
    }
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(";").shift();
    }

    if(getCookie('startCount')) {
        document.cookie = 'startCount=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;'
        waiting();
    }

</script>