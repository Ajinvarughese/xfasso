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
            if ($_FILES['img1']['error'] !== UPLOAD_ERR_OK || $_FILES['img2']['error'] !== UPLOAD_ERR_OK || $_FILES['img3']['error'] !== UPLOAD_ERR_OK || $_FILES['img4']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Please upload all the required images.");
            } else {
                $imgFront = file_get_contents($_FILES['img1']['tmp_name']);
                $imgRight = file_get_contents($_FILES['img2']['tmp_name']);
                $imgLeft = file_get_contents($_FILES['img3']['tmp_name']);
                $imgBack = file_get_contents($_FILES['img4']['tmp_name']);
            
                $imgFront = mysqli_real_escape_string($conn, $imgFront);
                $imgRight = mysqli_real_escape_string($conn, $imgRight);
                $imgLeft = mysqli_real_escape_string($conn, $imgLeft);
                $imgBack = mysqli_real_escape_string($conn, $imgBack);
                
                // Insert or update queries
                $quer1 = "UPDATE products SET product_id={$prodID}, product_name='{$prod_name}', product_price={$prod_price}, product_image = '{$imgFront}', product_gender='{$gender}', product_date=CURRENT_TIMESTAMP WHERE product_id={$prodID}";
                $quer2 = "UPDATE product_images SET product_id={$prodID}, img_front='{$imgFront}', img_back='{$imgBack}', img_right='{$imgRight}', img_left='{$imgLeft}', product_desc='{$desc}' WHERE product_id={$prodID}";
                
                mysqli_query($conn, $quer1);
                mysqli_query($conn, $quer2);
            }
        } catch(Exception) {
            // Handle exception
            $_SESSION['noInput'] = true;
            $_SESSION['failureprodID'] = $prodID;
            
            header('Location: ../edit.php');
            exit(); // Terminate script execution
        }
        
        $_SESSION['successedID'] = $prodID;
        $_SESSION['productAdded'] = true;
        header('Location: ../edit.php');
        exit(); // Terminate script execution
        
    } else {
        // Redirect if not a POST request
        header('Location: ../../../../404/');
        exit(); // Terminate script execution
    }
?>
