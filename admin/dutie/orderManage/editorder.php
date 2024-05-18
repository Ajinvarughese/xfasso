<?php 
    session_start();
    require_once '../../../connections/productdb.php';
    if(empty($_SESSION['XQCLANG'])){
        header('Location: ../../admin-login/');
    }else {
        if(isset($_GET['product_id']) && isset($_GET['order_id']) && isset($_GET['user_id'])) {
            $prod_id = mysqli_escape_string($conn, $_GET['product_id']);
            $order_id = mysqli_escape_string($conn, $_GET['order_id']);
            $user_id = mysqli_escape_string($conn, $_GET['user_id']);

            echo "$prod_id <br> $order_id <br> $user_id";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit order details</title>
</head>
<body>
    
</body>
</html>