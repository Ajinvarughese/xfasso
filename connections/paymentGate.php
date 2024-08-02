<?php 
    session_start();
    if(isset($_POST['UPIpay'])) {
        $_SESSION['payment_method'] = 'UPI';
        $_SESSION['ordered'] = true;
        
    }else if(isset($_POST['NETpay'])) {
        // $_SESSION['payment_method'] = 'netbanking';
        // header('Location: ../checkout/u/netbanking/netbanking.php');
        echo "
            <script>
                window.history.back();
            </script>
        ";
    }else {
        echo "
            <script>
                window.history.back();
            </script>
        ";
    }
?>