<?php 
    require_once('../../connections/productdb.php');
    session_start();

    function countSpy() {
        if(empty($_SESSION['tryCount'])) {
            $_SESSION['tryCount'] = 0;
        }            
        $_SESSION['tryCount']++;

        if($_SESSION['tryCount']>3) {
            echo "You've tried enough now wait in this page for 30seconds";
        echo $_SESSION['tryCount'];
            echo "
                <script>
                    function getCookie(name) {
                        const value = '; \${document.cookie}';
                        const parts = value.split('; \${name}=');
                        if (parts.length === 2) return parts.pop().split(";").shift();
                    }


                    <div id='timer'></div>
               
                    window.onload = function() {
                        var seconds = 30;
                        var countdown = setInterval(function() {
                            document.getElementById('timer').innerHTML = 'Seconds remaining: ' + seconds;
                            seconds--;
                            if (seconds < 0) {
                                clearInterval(countdown);
                                document.getElementById('timer').innerHTML = 'Countdown complete!';
                            }
                        }, 1000);
                    }
                    document.cookie = 'timerEnd=true';
                </script>
            ";
        }
    }

    if(isset($_POST['submit'])) {
        $adm_id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);

        $setIt = "SELECT admin_id, password FROM admin WHERE admin_id = '$adm_id'";
        $getIt = mysqli_query($conn, $setIt);

        if(mysqli_num_rows($getIt)>0) {
            $row = mysqli_fetch_assoc($getIt);
            if(password_verify($password, $row['password'])) {
                
                echo "YESSSSS";
            }else {
               echo countSpy();

                echo "sorry you've tried enough now wait in this page";
            }
        }else {
            echo countSpy();
        }
    }

    mysqli_close($conn);
?>