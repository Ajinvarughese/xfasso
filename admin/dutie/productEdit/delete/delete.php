<?php 
    session_start();
    require_once ('../../../../connections/productdb.php');
    if(empty($_SESSION['XQCLANG'])){
        header('Location: ../../../admin-login/');
    }

    foreach($_POST as $p => $v) {
        if(isset($p)) {
            $prodID = $v;
            break;
        }
    }

    if(is_numeric($prodID)) {
        $_SESSION['prodIdToDelete'] = $prodID;
    }
    
    if(empty($prodID)) {
        header('Location: ../productEdit.php');
    }

    if(isset($_POST['delete'])) {
        $prodID = $_SESSION['prodIdToDelete'];
        $_SESSION['prodIdToDelete'] == NULL;

        mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=0');
        $querDltImgs = "DELETE FROM product_images WHERE product_id = {$prodID}";
        $querDlt = "DELETE FROM products WHERE product_id = {$prodID}";
        $querCart = "DELETE FROM cart_user WHERE cart_product = {$prodID}";
        try {
            mysqli_query($conn, $querDltImgs);
            mysqli_query($conn, $querDlt);
            mysqli_query($conn, $querCart);
            $_SESSION['dltSuccess'] = true;
            echo "
                <script>
                    window.location.href='../productEdit.php';
                </script>
            ";
        }catch(mysqli_sql_exception $q) {
            echo "Error occured try again or contact executer.";
            echo "
                <script>
                    setTimeout(()=> {
                        window.location.href='../productEdit.php';
                    },5000)
                </script>
            ";
        }

    }elseif(isset($prodID)) {
        mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=1');
        $query = "SELECT * FROM products WHERE product_id = '{$prodID}'";
        $run = mysqli_query($conn, $query); 
        if(mysqli_num_rows($run)>0) {
            $res = mysqli_fetch_assoc($run);

            $prodName = $res['product_name'];
            $prodPrice = $res['product_price'];
            $prodGender =$res['product_gender']; 

            $imageType = 'image/jpeg';
            $imageData = base64_encode($res['product_image']);
        }        
    }

    empty($prodName)?$prodName= "": $prodName;
    empty($prodPrice)?$prodPrice = "": $prodPrice;
    empty($prodGender)?$prodGender = "": $prodGender;
    
    empty($imageType)?$imageType = "": $imageType;
    empty($imageData)?$imageData = "": $imageData;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Products</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        body {
            background: #f3f1f1f3;
        }
        .main {
            margin-bottom: 3rem;
            padding-top: 6.7rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div onclick="goBacks()" class="back">
            <img src="../../../images/back.png" alt="back">
        </div>
        <div class="logo"><h2>XFASSO<h2></div>
        <div id="drop" class="admin">
            <div class="prof">
                <img src="../../../../resources/user.png" alt="user">
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
        <h2>Do you want to delete the product</h2>
        <br>
        <br>
        <div class="card">
            <div class='a'>
                <div class='cardImg'>
                    <img <?php echo "src='data:$imageType;base64,$imageData' alt='image of {$prodName}'"?>>
                </div>
                <hr>
                <div class='cardContents'>
                    <div class='id'><span>product ID:</span><?php echo $prodID; ?></div>
                    <div class='name'><span>name:</span><?php echo $prodName; ?></div>
                    <div class='price'><span>price:</span><?php echo $prodPrice; ?></div>
                    <div class='gender'><span>gender:</span><?php echo $prodGender; ?></div>
                </div>
            </div>
        </div>
        <style>
            form {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-top: 1.5rem;
                width: 86%;
                max-width: 820px;
                margin: 0 auto;
            }
            form .p {
                opacity: 0.9;
                font-size: 14px;
            }
            .btns {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
            .button, input[type=submit] {
                padding: 6px 22px;
                cursor: pointer;
                border-radius: 3px;
                font-size: 14px;
                transition: 0.3s ease;
            }
            .button {
                background: #fff;
                border: 1px solid #c2c2c2c2;
            }
            input[type=submit] {
                background: #121b12df;
                color: #fff;
                border: 1px solid #121b12df;
            }
            
        </style>
        <form method="post">
            <div class="p">Delete the product</div>
            <div class="btns">
                <div class="button" onclick="cancel()">Cancel</div>
                <div class="submit">
                    <input name="delete" type="submit" value="Delete">
                </div>
            </div>
        </form>
    </div>

</body>
<script>
    function goBacks() {
        window.location.href = '../../../admin.php';
    }
    function cancel() {
        window.location.href = '../productEdit.php';
    }
</script>
<script src="../../main.js"></script>
</html>