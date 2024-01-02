<?php 
    require '../connections/productdb.php';
    session_start();
    if(isset($_POST["subOtp"])) {
        $email = $_SESSION['email'];
        $otpEnter = $_POST['otp'];

        $q = "SELECT * FROM otp WHERE email='$email'";
        $runQ = mysqli_query($conn, $q);

        if(mysqli_num_rows($runQ) > 0) {
            $row = mysqli_fetch_array($runQ);
            if($otpEnter == $row['otp'] && $email = $row['email']) {
                setcookie('trueOtp', 'true', time()+3600, '/');
                header('Location: ./reset.php');
            }else {
                
                setcookie('wrongOtp','true', time()+3600,'/');
                header('Location: ./reset.php');
            }
        }else {
            header('Location: ./reset.php');
        }
    }
?>

<?php 
    mysqli_close($conn);
?>