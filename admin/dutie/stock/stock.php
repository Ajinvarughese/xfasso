<?php 
    session_start();
    require_once '../../../connections/productdb.php';
    $quer = "SELECT * FROM products";
    $run = mysqli_query($conn, $quer);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="nav">
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
                                        <input name='' type='text' style='padding: 2px; width:40px; text-align: center; font-size:15px;' value='{$prodStock}' >
                                    </td>
                                </tr>
                            ";
                        }
                    }
                ?>
                
            </table>
            <div class="sub" class="final">
                <p style="font-size: 13px;">Make sure before you submit the changes: </p>    
                <input type="submit">
            </div>
        </form>
    </div>
</body>
</html>