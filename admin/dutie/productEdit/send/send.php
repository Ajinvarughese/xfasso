<?php 
    require_once('../../../../connections/productdb.php');
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $prod_name = mysqli_real_escape_string($conn, $_POST['prod_name']);
        $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $prodID = mysqli_real_escape_string($conn, $_POST['prod_id']);

        try {
            if (!isset($_FILES['img1']['error']) ||
                !isset($_FILES['img2']['error']) ||
                !isset($_FILES['img3']['error']) ||
                !isset($_FILES['img4']['error'])) {
                throw new Exception("Please upload all the required images.");
            }else {
                $imgFront = file_get_contents($_FILES['img1']['tmp_name']);
                $imgRight = file_get_contents($_FILES['img2']['tmp_name']);
                $imgLeft = file_get_contents($_FILES['img3']['tmp_name']);
                $imgBack = file_get_contents($_FILES['img4']['tmp_name']);
            }
        }catch(Error) {
            mysqli_close($conn);
            $_SESSION['noInput']=true;
            echo" <script>
                window.location.href = '../edit.php';
            </script>";
        }
       
        $imgFront = mysqli_real_escape_string($conn, $imgFront);
        $imgRight = mysqli_real_escape_string($conn, $imgRight);
        $imgLeft = mysqli_real_escape_string($conn, $imgLeft);
        $imgBack = mysqli_real_escape_string($conn, $imgBack);

        $quer1 = "INSERT INTO products(product_id, product_name, product_price, product_image, product_gender) VALUES('$prodID','$prod_name', '$prod_price', '$imgFront', '$gender')";
        $quer2 = "INSERT INTO product_images(product_id, img_front, img_back, img_right, img_left, product_desc) VALUES('$prodID','$imgFront', '$imgBack', '$imgRight', '$imgLeft', '$desc')";
        
        $q = "SELECT product_id FROM products WHERE product_id = '$prodID'";
        $r = mysqli_query($conn, $q);
        if(mysqli_num_rows($r)>0) {
            echo "This product alredy Exists";
        }else {
            try {
                mysqli_query($conn, $quer1);
                mysqli_query($conn, $quer2);
            }catch(mysqli_sql_exception $e) {
                echo $e->getMessage();
                echo "Upload error occured";
            }
            echo "
                <script>
                    window.location.href = '../edit.php';
                </script>
            ";
            $_SESSION['productAdded'] = true;
        }
        
    }else {
        header('Location: ../../../../404/');
    }

    mysqli_close($conn);
?>