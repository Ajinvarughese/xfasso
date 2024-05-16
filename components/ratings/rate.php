<?php 
    require '../../connections/productdb.php';
    require './Ratings.php';
    require_once '../../checkexistence/checkExistence.php';
    session_start();

    // error_reporting(0);

    $_SESSION['UPDATE_STARCOUNT'] = false;
    if(isset($_COOKIE['XassureUser'])) {

        $emailId = mysqli_escape_string($conn, $_COOKIE['XassureUser']);
        $cookiePassword = mysqli_escape_string($conn, $_COOKIE['X9wsWsw32']);

        if(checkUserExistence($conn, $emailId, $cookiePassword) == false) {
            header('Location: ../signup/signup.html');
        }

        // //decrypting
        // $ciphering = "AES-128-CTR";
        // $options = 0;
        // $decryption_iv = '1234567891021957';
        // $decryption_key = "xfassoKey";
        // $decrypted_id = openssl_decrypt($emailId, $ciphering, $decryption_key, $options, $decryption_iv);
        // $email = $decrypted_id;

        // $qTitle = "SELECT * FROM users WHERE email='$email'";
        // $res = mysqli_query($conn, $qTitle);
        // if(mysqli_num_rows($res) > 0) {
        //     $row = mysqli_fetch_array($res);
        //     $user_id = $row["user_id"];
        //     $username = $row["username"];
        // }

    }else {
        header('Location: ../signup/signup.html');
    }

    if(isset($_POST["postRating"])) {
        $initiateDelete = false;
        if(isset($_POST['stars']) && isset($_POST['description'])) {
            $starCount = filter_var($_POST['stars'], FILTER_SANITIZE_NUMBER_INT);
            $desc = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS); 
        }else {
            $starCount= NULL;
            $desc = NULL;
            $initiateDelete = true;
        }

        if(isset($_SESSION['PRODUCT_ID_ORDERDETAILS']) && isset($_SESSION['USER_ID_ORDERDETAILS'])) {
            if($_SESSION['PRODUCT_ID_ORDERDETAILS'] != false || $_SESSION['USER_ID_ORDERDETAILS'] != false) {
                $prodId = $_SESSION['PRODUCT_ID_ORDERDETAILS'];
                $userId = $_SESSION['USER_ID_ORDERDETAILS'];
                if(isset($prodId) && isset($userId)) {
                    $_SESSION['PRODUCT_ID_ORDERDETAILS'] = false;
                    $_SESSION['USER_ID_ORDERDETAILS'] = false;
                } 
            } else {
                echo "
                    <script>
                        window.history.back();
                    </script>
                ";
            } 

        }else {
            header("Location: ../../errors/errors.php?errorID=1025");
        }
        $day = date("F d Y");
        $rating = new Ratings($prodId, $starCount, $userId, $desc, $day);

        
        $ratingObject = 
            array(
                "productID" => $rating->getProductID(),
                "userID" => $rating->getUser(),
                "starCount" => $rating->getCount(),
                "description" => $rating->getDesc(),
                "day" => $rating->getDay()
            );

        $ratingJSON = json_encode($ratingObject, JSON_PRETTY_PRINT);

        
        $fetchQ = "SELECT rating FROM products WHERE product_id = '{$rating->getProductID()}'";
        $result = mysqli_query($conn, $fetchQ);


        if (mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_assoc($result);
            
            if($initiateDelete) {
                $jsonDelete = $row['rating'];
                $objDelete = json_decode($jsonDelete, true);
                if($objDelete == NULL) {
                    echo "
                        <script>
                            window.history.back();
                        </script>
                    ";
                    $appendNewPost = "SELECT rating FROM products;";
                }else {
                    for($i=0; $i<count($objDelete); $i++) {
                        if($objDelete[$i]['userID'] == $userId) {
                            $i == 0? $objDelete = '' : $objDelete[$i] = '';
                            break;
                        }
                    }
                    $newRatingJson = json_encode($objDelete, JSON_PRETTY_PRINT);
                    $appendNewPost = "UPDATE products SET rating =  {$newRatingJson} WHERE product_id = '$prodId'";
                }
            }else {
                if($row['rating'] == NULL) {
                    $appendNewPost = "UPDATE products SET rating = '[{$ratingJSON}]' WHERE product_id = '$prodId'";
                }
                else {
                    $ratingPHPOBJ = json_decode($row['rating'], true);
                    $flag = 0;
                    for($i=0; $i<count($ratingPHPOBJ); $i++) {
                        if($ratingPHPOBJ[$i]["userID"] == $userId) {
                            $flag = 1;
                            break;
                        }
                    }

                    if($flag == 1) {
                        $ratingPHPOBJ[$i]['starCount'] = $ratingObject['starCount'];
                        $ratingPHPOBJ[$i]['description'] = $ratingObject['description'];
                        $ratingPHPOBJ[$i]['day'] = $ratingObject['day'];
                    }else {
                        $ratingPHPOBJ[] = $ratingObject;
                    }
                    $ratingJSONUpdate = json_encode($ratingPHPOBJ, JSON_PRETTY_PRINT);
                    $appendNewPost = "UPDATE products SET rating = '{$ratingJSONUpdate}'  WHERE product_id = '$prodId'";
                    
                }

            }       
        
            if($runAppend = mysqli_query($conn, $appendNewPost)) {
                $q = "SELECT * FROM products WHERE product_id = '{$prodId}'";
                $r = mysqli_query($conn, $q);
                $ratingArray = array();
                if($res = mysqli_fetch_assoc($r)) {
                    if($res['rating']!=NULL) {
                        $ratingArray[] = json_decode($res['rating'],true);
                    }else {
                        $ratingArray = NULL;
                    }
                    if($ratingArray != NULL) {
                        $totalElements = 0;
                        $totalStarCount = 0;
                        
                        for($i = 0; $i < count($ratingArray); $i++) {
                            for ($j = 0; $j < count($ratingArray[$i]); $j++) {
                                if ($ratingArray[$i][$j]['productID'] == $prodId) {
                                    $totalStarCount += $ratingArray[$i][$j]['starCount'];
                                    $totalElements++;
                                }
                            }
                        }
                    }else {
                        $totalStarCount = 0;
                        $totalElements = 0;
                        $averageStarCount = 0;
                    }


                    // Calculate average star count for the current product
                    if ($totalElements > 0) {
                        $averageStarCount = number_format($totalStarCount / $totalElements, 1);
                    } else {
                        $averageStarCount = 0;
                    }
                    // set avg_star count to DB
                    $quer = "UPDATE products SET avg_star='{$averageStarCount}' WHERE product_id = '{$prodId}'";
                    if($querRUN = mysqli_query($conn, $quer)) {
                        $_SESSION['UPDATE_STARCOUNT'] = true;
                    }

                }
            }else {
                echo "
                    <script>
                        window.location.href = '../../errors/errors.php?errorID=1025';
                    </script>
                ";
            }
        }
    
    }
    mysqli_close($conn);

    echo "
        <script>
            window.history.back();
        </script>
    ";
?>
