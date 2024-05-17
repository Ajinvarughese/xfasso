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
    <style>
        body {
            background: #f3f1f1f3;
        }
        .main {
            margin-bottom: 3rem;
        }
    </style>
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

    <div id="success" class="awq2s">
        <div class="success" >
            <div class="ais">
                <div class="imgasd">
                    <img src="../../images/tick.png">
                </div>
            </div>
            <div class="contentTick">
                <p>product deleted succesfully.</p>
            </div>
        </div>
    </div>

    <style> 
        .awq2s {
            display: none;
        }
        .success {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            display: flex;
            flex-direction: column;
            width: 80%;
            max-width: 289px;
            height: 229px;
            box-shadow: 4px 4px 10px rgba(0,0,0,0.15);
        }
        .ais {
            background: #43ef43;
            height: 134.5px;
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: center;
        }
        .imgasd {
            width: 88px;
            height: 88px;
        }
        .imgasd img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        .contentTick {
            background: #fff;
            height: 94.5px;
            width: 100%;
        }
        .contentTick p {
            margin-top: 2rem;
            font-size: 18px;
            text-align: center;
            opacity: 0.9;
        }


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
        .a{
            display: flex;
            border-radius: 4px;
            gap: 1rem;
            background: #fff;
            width: 89%;
            max-width: 830px;
            margin: 0 auto;
            transition: 0.2s ease;  
            max-height: 180px;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.15);
        }
        .form {
            padding: 0;
            margin-top: 1.7rem;
            cursor: pointer;
        }
        .form label {
            cursor: pointer;
        }
        .form hr {
            margin: 12px 0;
        }
        .form input {
            display: none;
        }
        .a:hover {
            transform: scale(1.02);
        }
        .cardImg {
            max-width: 179px;
            max-height: 179px;
            padding: 4px;
        }
        .cardImg img {
            max-width: 100%;
            max-height: 100%;
        }
        .cardContents {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-left: 0.6rem;
            width: 100%;
        }
        .cardContents > div {
            margin-bottom: 7.2px;
        }
    </style>
    <div class="main">
        <h2 align="center" class="head1">All of our products</h2>
        <?php 
            $quer = "SELECT * FROM products INNER JOIN product_images ON products.product_id = product_images.product_id ORDER BY products.product_date DESC";
            $res = mysqli_query($conn, $quer);
            if(mysqli_num_rows($res)>0) {
                $i=0;
                while($row=mysqli_fetch_assoc($res)) {
                    $id = $row['product_id'];
                    $prodName = $row['product_name'];
                    $price = $row['product_price'];
                    $gender = $row['product_gender'];

                    $imageData = base64_encode($row['product_image']);
                    $imageType = "image/jpeg";
                    echo "
                        <form class='form' action='./edit.php' method='post' enctype='multipart/form-data'>
                            <input type='password' name='product_id{$i}' value ='{$id}'>
                            <input type='submit' name='submit{$i}' id='submit{$i}'>
                            <label for='submit{$i}'>
                                <div class='a'>
                                    <div class='cardImg'>
                                        <img src='data:$imageType;base64,$imageData' alt='image of {$prodName}'>
                                    </div>
                                    <hr>
                                    <div class='cardContents'>
                                        <div class='id'><span>product ID:</span> {$id}</div>
                                        <div class='name'><span>name:</span> {$prodName}</div>
                                        <div class='price'><span>price:</span> {$price}</div>
                                        <div class='gender'><span>gender:</span> {$gender}</div>
                                    </div>
                                </div>
                            </label>
                        </form>
                    "; 
                    $i++;
                }
            }
        ?>


        <h2 style="margin-top: 3rem;" align="center" class="head1">Delete Product</h2>
        <?php 
            $quer = "SELECT * FROM products ORDER BY product_date DESC";
            $res = mysqli_query($conn, $quer);
            if(mysqli_num_rows($res)>0) {
                while($row=mysqli_fetch_assoc($res)) {
                    $id = $row['product_id'];
                    $prodName = $row['product_name'];
                    $price = $row['product_price'];
                    $gender = $row['product_gender'];

                    $imageData = base64_encode($row['product_image']);
                    $imageType = "image/jpeg";
                    echo "
                        <form class='form' action='./delete/delete.php' method='post' enctype='multipart/form-data'>
                            <input type='password' name='product_id{$i}' value ={$id}>
                            <input type='submit' name='submit{$i}' id='submit{$i}'>
                            <label for='submit{$i}'>
                                <div class='a'>
                                    <div class='cardImg'>
                                        <img src='data:$imageType;base64,$imageData' alt='image of {$prodName}'>
                                    </div>
                                    <hr>
                                    <div class='cardContents'>
                                        <div class='id'><span>product ID:</span> {$id}</div>
                                        <div class='name'><span>name:</span> {$prodName}</div>
                                        <div class='price'><span>price:</span> {$price}</div>
                                        <div class='gender'><span>gender:</span> {$gender}</div>
                                    </div>
                                </div>
                            </label>
                        </form>
                    "; 
                    $i++;
                }
            }
        ?>
        
    </div>
    
</body>
<script src="../main.js"></script>
<script>
    window.addEventListener('click', ()=> {
        let success = document.getElementById('success');
        success.style.display = 'none';
    })
</script>
<?php 
    if(isset($_SESSION['dltSuccess'])) {

        $_SESSION['dltSuccess'] = NULL;
        echo "
        <script>
            let success =document.getElementById('success');
            success.style.display = 'block';
            setTimeout(()=> {
                success.style.display = 'none';
            },3000)
        </script>
        ";
    }
?>
</html>