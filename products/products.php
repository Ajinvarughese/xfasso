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
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    
    

    <style>
        *{
            margin: 0;
            padding: 0 0.5%;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
            color: #12263a;
        }
        ::-webkit-scrollbar{
            display: none;
        }
        .price-button {
            align-items: center;
        }
        .inw{
            margin: 0;
            padding: 0;
        }
        .button-primary {
            cursor: pointer;
            transition: 0.3s ease;
            background: #fff;
            text-decoration: none;
            border: 1px solid #12263a;
            padding: 5px 20px;
            color: #12263a;
        }
        .button-primary:hover {
            background: #12263a;
            color: #fff;
        }
        @media (max-width: 320px) {
            .button-primary {
                padding: 4px 12px;
            }
        }
        html {
            scroll-behavior: smooth;
        }
        ._S43p {
            min-height: 90vh;
        }
        .filter-sort p:hover{
            text-decoration: underline;
        }
        .filter-sort {
            width: fit-content;
            cursor: pointer;
            -webkit-user-select: none;
            -ms-user-select: none; 
            user-select: none;
        }
        ._i92 {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .rate {
            font-size: 14.2px;
            margin-top: 4px;
        }
        .star {
            width: 14.2px;
        }
                        

        .emailSending {
            display: block;
        }

        .filter-menu {
            border: 1px solid;
            margin-top: 12px;
            position: absolute;
            transition: 0.5s ease;
            left: -110%;
            z-index: 1;
            background: #fff;
            padding: 1rem 1rem;

        }

        #_1menu-filter {
            display: none;
        }


        .products {
            min-height: 64vh;
            padding-top: 0;
        }

        .button-products {
            cursor: pointer;
            transition: 0.3s ease;
            background: #fff;
            text-decoration: none;
            border: 1px solid #12263a;
            padding: 5px 20px;
            color: #12263a;
        }
        .button-products:hover {
            background: #12263a;
            color: #fff;
        }

        .reset {
            cursor: pointer;
            background: none;
            border: none;
            padding: 4px 10px;
            text-decoration: underline;
        }

        .button-menu {
            background: #12263a;
            border: none;
            color: #fff;
            padding: 7px 28px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .button-menu:hover {
            transform: scale(1.1);
        }

        .shop-main {
            padding: 0 !important;
        }

        .body-Content {
        
            min-height: 100vh;
            height: unset;
            max-height: unset;
        }
        .products {
           
            min-height: 100vh;
            height: unset;
            max-height: unset;
            display: flex;
            justify-content: center;
        }
        .card-container {
            margin-top: 0;
            float: left;
            min-height: 100vh;
            height: unset;
            max-height: unset;
            display: grid;
            grid-template-columns: auto auto auto auto;
            gap: 2rem;
        }
        .card {
            max-width: 290px;
            transition: 0.2s ease;
            max-height: 329px;
        }
        .product-img img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        @media (max-width: 940px) {
            .card-container {
                grid-template-columns: auto auto auto;
                gap: 5rem 2rem;
            }
            .body-Content {
                padding-bottom: 5rem;
            }
        }
        @media (max-width: 650px) {
            .card-container{
                grid-template-columns: auto auto;
            }
        }

        .content-product {
            margin-top: -5px;
            padding: 0.5rem 1rem;
            height: 18%;
            display: flex;
            flex-direction: column;
            
        }

        .price-button {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }
        .content-product h2 {
            font-size: 19.4px;
        }
        .card:hover {
            transform: scale(1.03);
        }

        @media (max-width: 912px) {
            body {
                padding: 0;
            }
        }
        @media (max-width: 440px) {
            .card-container {
                gap: 2rem 14px;
            }
        }

        @media (max-width: 300px) {
            .card-container {
                grid-template-columns: auto;
            }
        }
    </style>
</head>
<body class="body-Content">
    <div class="products">
        <div class="card-container">
            <?php 
                 if(mysqli_num_rows($productQueryResult)>0) {
                    function isInteger($value) {
                            return is_numeric($value) && intval($value) == $value;
                        }
                    while($productRow = mysqli_fetch_assoc($productQueryResult)) {
                        if($productRow['stock_status'] != 0){

                            $productId = "productIdOfXfassoYes {$productRow['product_id']}";

                            $averageStarCount = $productRow['avg_star'];

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
                                            <h2 id='primary' class='inw'>{$productRow['product_name']}</h2>

                                            <p  style='display:flex; align-items:center;' class='inw secondary rate'>"; 
                                                    if($averageStarCount > 0) {
                                                        if(isInteger($averageStarCount)) {
                                                            for($k=0; $k<$averageStarCount; $k++) {
                                                                echo "<span><img src='../resources/icons8-star-50.png' class='star'></span>";
                                                            }
                                                            for($k=0; $k<5-$averageStarCount; $k++) {
                                                                echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                                            }
                                                        }else {
                                                            for($k=0; $k<$averageStarCount-1; $k++) {
                                                                echo "<span><img src='../resources/icons8-star-50.png' class='star'></span>";
                                                            }
                                                            echo "<span><img src='../resources/icons8-star-half-empty-50.png' class='star'></span>";
                                                            for($k=0; $k<5-$averageStarCount-1; $k++) {
                                                                echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                                            }
                                                        }
                                                        echo " {$averageStarCount}";
                                                    }else {
                                                        for($k=0; $k<5; $k++) {
                                                            echo "<span><img src='../resources/empty-star.png' class='star'></span>";
                                                        }
                                                    }
                                                    echo "</p>
                                            <div class='price-button inw'>
                                                <p class='secondary'>₹{$productRow['product_price']}</p>
                                                <a href='../details/details.php?productId={$encrypted_id}' target='_parent'><button class='button-primary'>view</button></a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            ";
                        }
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