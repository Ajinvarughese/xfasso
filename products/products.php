<?php 
    require('../connections/productdb.php');
    
    $productSqlQuery = "SELECT * FROM products ORDER BY RAND()";
    $productQueryResult = mysqli_query($conn, $productSqlQuery);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/products.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
            

</head>
<body class="body-Content">
    <div class="products">
        <div class="card-container">
            <?php 
                 if(mysqli_num_rows($productQueryResult)>0) {
                    while($productRow = mysqli_fetch_assoc($productQueryResult)) {

                        $productId = "productIdOfXfassoYes {$productRow['product_id']}";

                        //encrypting
                    
                        $ciphering = "AES-128-CTR";
                        $iv_length = openssl_cipher_iv_length($ciphering);
                        $options = 0;
                        $encryption_iv = '1234567891021957';
                        $encryption_key = "xfassoKey";
                        $encrypted_id = openssl_encrypt($productId, $ciphering, $encryption_key, $options, $encryption_iv);



                        $imageData = base64_encode($productRow['product_image']);
                        $imageType = "image/jpeg";
                        echo "
                            <div id='{$encrypted_id}' class='card'>
                                <a style='color: inherit; text-decoration: none;' href='../details/details.php?productId={$encrypted_id}' target='_parent'>
                                    <div class='product-img'>
                                        <img src='data:$imageType;base64,$imageData' alt='img'>
                                    </div>
                                    <div class='content-product'>
                                        <h2 id='primary'>{$productRow['product_name']}</h2>
                                        <div class='price-button'>
                                            <p class='secondary'>₹{$productRow['product_price']}</p>
                                            <a href='../details/details.php?productId={$encrypted_id}' target='_parent'><button class='button-primary'>view</button></a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        ";
                    }
                    
                }
            ?>
        </div>
    </div>
</body>
</html>

<?php 
    mysqli_close($conn);
?>