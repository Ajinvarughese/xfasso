<?php 
    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    if(isset($_POST["submit"])) {
        try {


            $user_message = filter_var($_POST['email-text'], FILTER_SANITIZE_SPECIAL_CHARS);
            
            date_default_timezone_set("Asia/Kolkata");
            $date = date("d-m-Y h:i:s A");
            $message = "
                <head>
                    <style>
                        *{
                            margin: 0;
                            padding: 0;
                            font-family: Verdana, Geneva, Tahoma, sans-serif;
                        }
                    </style>
                </head>

                <div style='background: #fff; color: #000; padding: 3% 4%;' class='mail-main'>
                    <div class='_u2' style='border: 1px solid; padding: 10% 5%;'>
                        <div class='username'><h4>User: Ajin</h4></div>
                        <hr>
                        <br>
                        <div class='time'><h4>Date: {$date}</h4></div>
                        <hr>
                        <br>
                        <div class='subject'>
                            <h4>Subject: </h4>
                            <br>
                            <p style='color: rgba(28, 26, 26, 0.753);'>{$user_message}</p>
                            <hr>
                        </div>
                    </div>
                </div>
            ";
            
            $mail = new PHPMailer(true);

            $mail -> isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'xfassofashion@gmail.com';
            $mail->Password = 'efoovowwgtdoxrih';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('xfassofashion@gmail.com'); // the sended from email

            $mail->addAddress('xfassofashion@gmail.com'); //the send to email
            $mail->isHTML(true);
            $mail->Subject = 'User\'s thoughts!';
            $mail->Body = $message;
            $mail->send();

            echo "
                <script>
                    var cookieExpires = new Date(Date.now() + 100 * 1000).toUTCString();
                    document.cookie = 'message-sent=messageSentTrue; expires='+ cookieExpires +'; path=/';       
                    window.history.back();
                </script>
            ";
        }
        catch(Exception) {
            echo "
                <script>
                    window.location.href = '../errors/errors.php?errorID=1015';
                </script>
            ";
        }

    }
?>
