<?php 
    session_start();
    require_once '../../../connections/productdb.php';
    
    if(empty($_SESSION['XQCLANG'])){
        header('Location: ../../admin-login/');
    }
    
    $quer = "SELECT * FROM products";
    $run = mysqli_query($conn, $quer);

    $upQuer = "SELECT product_id FROM products";
    $upRun = mysqli_query($conn, $upQuer);

    $prod = array();
    if(mysqli_num_rows($upRun)>0) {
        while($upRow= mysqli_fetch_assoc($upRun)) {
            $prod[] = $upRow['product_id'];
        }
    }
 
    if(isset($_POST['submit'])) {

        for($i=0; isset($_POST["prod$i"]); $i++) {
            $updateProdID = $prod[$i];
            if($_POST["prod$i"] == 1) { 
                $updateQuery = "UPDATE products SET stock_status = 1 WHERE product_id = $updateProdID";
                mysqli_query($conn, $updateQuery);
            }else {
                $pro = $updateProdID;
                $updateQuery = "UPDATE products SET stock_status = 0 WHERE product_id = $updateProdID";
                mysqli_query($conn, $updateQuery);
                $dltFrmCart = "DELETE FROM cart_user WHERE cart_product = $pro";
                mysqli_query($conn, $dltFrmCart);
            }
            
        }
        header("Location: ./stock.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>


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
    <div class="main">
        
        <form action="" method="post">
            <table>
                <tr>
                    <th>Image</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>

                <?php 
                    if(mysqli_num_rows($run)>0) {
                        $i=0;
                        while($res = mysqli_fetch_assoc($run)) {

                            $imageData = base64_encode($res['product_image']);
                            $imageType = "image/jpeg";

                            $prodID = $res['product_id'];
                            $prodName = $res['product_name'];
                            $prodPrice = $res['product_price'];
                            $prodStock = $res['stock_status'];
                            echo "
                                <tr>
                                    <td class='image'>
                                        <img src='data:$imageType;base64,$imageData' alt='image'>
                                    </td>
                                    <td class='id'>{$prodID}</td>
                                    <td class='prodName'>{$prodName}</td>
                                    <td class='prodPrice'>{$prodPrice}</td>
                                    <td class='stock'>
                                        <input name='prod$i' type='text' style='padding: 2px; width:40px; text-align: center; font-size:15px;' value='{$prodStock}' >
                                    </td>
                                </tr>
                            ";
                            $i++;
                        }
                    }
                ?>
                
            </table>
            <div class="sub" class="final">
                <p style="font-size: 13px;">Make sure before you submit the changes: </p>    
                <input type="submit" name="submit">
            </div>
        </form>
    </div>
</body>
<script src="../main.js"></script>
</html>