<?php 
    require_once('../../../../connections/productdb.php');
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $prod_name = mysqli_real_escape_string($conn, $_POST['prod_name']);
        $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $prodID = mysqli_real_escape_string($conn, $_POST['prod_id']);

        $success = false;
        echo $prodID;
        try {
            $s = "WHERE product_id={$prodID}";
            //update product names and details 
            $querDet = "UPDATE products SET product_id={$prodID}, product_name='{$prod_name}', product_price={$prod_price}, product_gender='{$gender}', product_date=CURRENT_TIMESTAMP WHERE product_id={$prodID}";
            $querDer2 = "UPDATE product_images SET product_desc = '{$desc}' WHERE product_id={$prodID}";
                //statements
            mysqli_query($conn, $querDet);
            mysqli_query($conn, $querDer2);
            //update product images okayyyyy!   

            //everything one-by-one update
            if ($_FILES['img1']['error'] == UPLOAD_ERR_OK) {
                $imgFront = file_get_contents($_FILES['img1']['tmp_name']);
                $imgFront = mysqli_real_escape_string($conn, $imgFront);

                $querImg = "UPDATE products SET product_image ='{$imgFront}' $s";
                $querImg2 = "UPDATE product_images SET img_front = '{$imgFront}' $s";
                mysqli_query($conn, $querImg);
                mysqli_query($conn, $querImg2);
            }
            if($_FILES['img2']['error'] == UPLOAD_ERR_OK) {
                $imgRight = file_get_contents($_FILES['img2']['tmp_name']);
                $imgRight = mysqli_real_escape_string($conn, $imgRight);

                $querImg = "UPDATE product_images SET img_right = '{$imgRight}' $s";
                mysqli_query($conn, $querImg);
            }
            if($_FILES['img3']['error'] == UPLOAD_ERR_OK) {
                $imgLeft = file_get_contents($_FILES['img3']['tmp_name']);
                $imgLeft = mysqli_real_escape_string($conn, $imgLeft);

                $querImg = "UPDATE product_images SET img_left='{$imgLeft}' $s";
                mysqli_query($conn, $querImg);
            }
            if($_FILES['img4']['error'] == UPLOAD_ERR_OK) {
                $imgBack = file_get_contents($_FILES['img4']['tmp_name']);
                $imgBack = mysqli_real_escape_string($conn, $imgBack);

                $querImg = "UPDATE product_images SET img_back ='{$imgBack}' $s";
                mysqli_query($conn, $querImg);           
            }
            $success = true;
        } catch(Exception) {
            // Handle exception
            $_SESSION['noInput'] = true;
            $_SESSION['failureprodID'] = $prodID;
            header('Location: ../edit.php');
            exit(); // Terminate script execution
        }
        
        if($success){
            $_SESSION['successedID'] = $prodID;
            $_SESSION['productAdded'] = true;
            header('Location: ../edit.php');
            exit(); // Terminate script execution
        }
    } else {
        // Redirect if not a POST request
        header('Location: ../../../../404/');
        exit(); // Terminate script execution
    }
?>
