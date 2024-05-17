<?php 
session_start();
require_once '../../../connections/productdb.php';


if(empty($_SESSION['XQCLANG'])){
    header('Location: ../../admin-login/');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>

     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="../../style.css">
</head>
<body>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
            color: #121b12df;
        }
        
        .back {
            width: 42px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .back:hover {
            transform: scale(1.07);
        }
        .back img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        .logo h2{
            font-size: 19px;
        }
    </style>    
    <div class="nav">
        <div onclick="goBack()" class="back">
            <img src="../../images/back.png" alt="back">
        </div>
        <div class="logo"><h2>XFASSO<h2></div>
        <div id="drop" class="admin">
            <div class="prof">
                <img src="../../../resources/user.png" alt="user">
            </div>
            <div id="showDrop" class="dropDown">
                <p><span>Status: </span><span class="gr"></span>Online</p>
                <hr>
                <p><span>ID:</span> <?php echo $_SESSION['XQCLANG'];?></p>
                <hr>
                <p><span>Work: </span> <?php echo "myWork";?></p>
                <hr>
                <button id="logOut">Logout</button>
            </div>
        </div>
    </div>
    <div class="main">
        <h1>Current orders</h1>
    </div>   
</body>
<script src="../main.js"></script>
</html>