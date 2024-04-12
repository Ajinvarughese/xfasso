<?php 
    require_once('../../connections/productdb.php');
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

    if(isset($_POST['submit'])) {
        $adm_id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);

        $setIt = "SELECT admin_id, password FROM admin WHERE admin_id = '$adm_id'";
        $getIt = mysqli_query($conn, $setIt);

        if(mysqli_num_rows($getIt)>0) {
            $row = mysqli_fetch_assoc($getIt);
            if($password == $row['password']) {
                echo "YESSSSS";
                //do the yes part for tomorrow!
            }else {
               countSpy();
            }
        }else {
            countSpy();
        }
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