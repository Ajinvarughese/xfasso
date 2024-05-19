<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($sender, $reciver, $message, $subject, $path) {
        include "{$path}phpmailer/src/Exception.php";
        include "{$path}phpmailer/src/PHPMailer.php";
        include "{$path}phpmailer/src/SMTP.php";
        
        
        try {
            
            date_default_timezone_set("Asia/Kolkata");
            $date = date("d-m-Y h:i:s A");
            
            
            $mail = new PHPMailer(true);

            $mail -> isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'xfassofashion@gmail.com';
            $mail->Password = 'efoovowwgtdoxrih';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom($sender); // the sended from email

            $mail->addAddress($reciver); //the send to email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();

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