<?php 
session_start();
require_once '../../../connections/productdb.php';


if(empty($_SESSION['XQCLANG'])){
    header('Location: ../../admin-login/');
}

if(isset($_POST['submit'])) {
    
    $order_id = mysqli_escape_string($conn, $_POST['order_id']);
    $user_id = mysqli_escape_string($conn, $_POST['user_id']);
    $product_id = mysqli_escape_string($conn, $_POST['product_id']);
    $order_status = mysqli_escape_string($conn, $_POST['order_status']);

    $quer = "UPDATE orders SET order_status = '$order_status' WHERE order_id='$order_id' AND user_id = '$user_id'";
    
    try {
        $run = mysqli_query($conn, $quer);
        $_SESSION['showSuccess'] = "happened";
    }
    catch(mysqli_sql_exception) {
        $_SESSION['showSuccess'] = "notHappend";
    }

    if($_SESSION['showSuccess']) {
        header('Location: orderManage.php');
    }

}else {
    header("Location: ../../admin.php");
}
?>