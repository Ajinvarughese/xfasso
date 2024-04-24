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
    <title>Edit Products</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
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
    <style> 
        .head1 {
            border-bottom: 1px solid;
            width: fit-content;
            margin: 0 auto;
            margin-bottom: 1.7rem;
            padding: 10px 2rem;
        }
        .cardContents span {
            opacity: 0.7;
            font-weight: 500;
            font-size: 14px;
            margin-right: 4px;
        }
        .card {
            border: 1px solid;
            display: flex;
            width: 90%;
            margin: 0 auto;  
            cursor: pointer;
            transition: 0.2s ease;          
        }
        .card:hover {
            transform: scale(1.02);
        }
        .cardImg {
            border-right: 1px solid;
            max-width: 188px;
            max-height: 188px;
        }
        .cardImg img {
            max-width: 100%;
            max-height: 100%;
        }
        .cardContents {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-left: 1.8rem;
            width: 100%;
        }
        .cardContents > div{
            margin-bottom: 7.2px;
        }
    </style>
    <div class="main">
        <h2 align="center" class="head1">Product with every details available</h2>
        <?php 
            $quer = "SELECT products.product_id, products.product_name, products.product_price, products.product_image, products.product_gender, product_images.img_front, product_images.img_back, product_images.img_right, product_images.img_left, product_images.product_desc FROM products INNER JOIN product_images ON products.product_id = product_images.product_id";
            $res = mysqli_query($conn, $quer);
            if(mysqli_num_rows($res)>0) {
                while($row=mysqli_fetch_assoc($res)) {
                    $r = $row['product_name'];
                    echo "<p>$r<p><br>"; 
                }
            }
        ?>
        <div class="card" id="card">
            <div class="cardImg">
                <img src="../../images/image_processing20200702-24592-2w0nhm.gif">
            </div>
            <div class="cardContents">
                <div class="id"><span>product ID:</span> 894</div>
                <div class="name"><span>name:</span> Helix</div>
                <div class="price"><span>price:</span> ₹2,999</div>
                <div class="gender"><span>gender:</span> Men</div>
            </div>
        </div>
    </div>
    
</body>
<script src="../main.js"></script>
</html>