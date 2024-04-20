<?php 
session_start();

require_once './works/worker.php';
require_once '../connections/productdb.php';


if(isset($_SESSION['XQCLANG'])){
    if($_SESSION['XQCLANG'] != false) {
        setWorkToJSON();
        $id = $_SESSION['XQCLANG'];
        $quer = "SELECT work FROM admin WHERE admin_id = '$id'";
        $res = mysqli_query($conn, $quer);

        if(mysqli_num_rows($res)>0) {
            $row = mysqli_fetch_assoc($res);
            $myTitle = getMyWork($row['work']);
        }
    }else {
        header('Location: ./admin-login/login.php');
    }   
}else {
    header('Location: ./admin-login/login.php');
}



function getMyWork($workID) {
    $jsonWork = file_get_contents('./work.json', true);
    $workObject = json_decode($jsonWork,true);
    
    for($i=0; $i<count($workObject); $i++) {
        if($workID === $workObject[$i]['workID']) {
            $workObject[$i]['workName'];
            break;
        }
    }
    switch($workObject[$i]['workName']) {
        case 'comments':
            $title = "
                <h1 id='workTitle' style='text-align: center;'>Let's check some spam messages!</h1>
                <p style='opacity: 0.8; text-align:center; margin-top: 10px; font-size: 17px;'>Your job is to delete the spam messages.</p>
            ";
            break;
        case 'productAdd':
            $title = "
                <h1 id='workTitle' style='text-align: center;'>Yeah we need to add new products!</h1>
                <p style='opacity: 0.8; text-align:center; margin-top: 10px; font-size: 17px;'>Your job is to add new products.</p>
            ";
            break;
        case 'stock':
            $title = "
                <h1 id='workTitle' style='text-align: center;'>We need to check the stocks!</h1>
                <p style='opacity: 0.8; text-align:center; margin-top: 10px; font-size: 17px;'>Your job is to edit the availablity of the products.</p>
            ";
            break;
        case 'blacklist':
            $title = "
                <h1 id='workTitle' style='text-align: center;'>Let's block some unwanted users!</h1>
                <p style='opacity: 0.8; text-align:center; margin-top: 10px; font-size: 17px;'>Your job is to block the users that have been found suspecious.</p>
            ";
            break;
        case 'productEdit':
            $title = "
                <h1 id='workTitle' style='text-align: center;'>Need some edit on current products?</h1>
                <p style='opacity: 0.8; text-align:center; margin-top: 10px; font-size: 17px;'>Your job is to edit the already created products.</p>
            ";
            break;
        default:
            $title = "We got works to do!";
            break;
    } 
    return $title;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PAGE</title>
    <link rel="stylesheet" href="style.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    
</head>
<body>
    <div class="main">
        <div class="nav">
            <div class="logo"><h2>XFASSO<h2></div>
            <div id="drop" class="admin">
                <div class="prof">
                    <img src="../resources/user.png" alt="user">
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

        <div class="header" >
            <div class="workerTitle">
                <?php 
                    echo $myTitle;
                ?> 
            </div>
            <div class="workerIllustrator">
                <img src="./images/image_processing20200702-24592-2w0nhm.gif" alt="worker.png">
            </div>
        </div>

        <div class="dutieMenu">
            <div class="head">
                <h2 class='mainhead'>Choose Your Dutie</h2>
                <p class='fn213ns'>Choose your dutie from the following options. Make sure all VPNs are turned off. <span>This page is highly confidential</span>. make sure about the safety. Any illegal things you do in this website will lead you to the law.</p>
            </div>
           
            <div class="duties" id='duties'></div>
        
        </div>
    </div>
    <div class="cp">
        <p>&copy; xfasso 2024</p>
    </div>
</body>
<script src="./js/admin.js"></script>
</html>