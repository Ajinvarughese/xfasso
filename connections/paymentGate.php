<?php 
    if(isset($_POST['UPIpay'])) {
        header('Location: ../checkout/u/upi.php');
    }else if(isset($_POST['NETpay'])) {
        // header('Location: ../checkout/u/netbanking.php');
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