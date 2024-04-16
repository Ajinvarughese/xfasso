<?php 
session_start();



if(isset($_SESSION['XQCLANG'])){
    if($_SESSION['XQCLANG'] != false) {
        echo "You are signed in sire";
        echo $_SESSION['XQCLANG'];
    }else {
        header('Location: ./admin-login/login.php');
    }   
}else {
    header('Location: ./admin-login/login.php');
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
        <div class="header">
            <div class="workerTitle">
                <h1>This is your work!</h1>
            </div>
            <div class="workerIllustrator">
                <img src="../resources/404.jpg" alt="worker.png">
            </div>
        </div>
        <div class="dutireMenu">
            <div class="head">
                <h2 class='mainhead'>Choose Your Dutie</h2>
                <p class='fn213ns'>Choose your dutie from the following options. Make sure all VPNs are turned off. <span>This page is highly confidential</span>. make sure about the safety. Any illegal things you do in this website will lead you to the law.</p>
            </div>
            <div class="duties">
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>

                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
                <div class="work">
                    <h3>TITLE</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="cp">
        <p>&copy; xfasso 2024</p>
    </div>
</body>
<script src="admin.js"></script>
</html>