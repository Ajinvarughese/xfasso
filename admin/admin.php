<?php 





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

    <style>
        .header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3rem 2%;
            border: 1px solid;
            min-height: 570px;
            gap: 1rem;
        }
        .workerTitle{
            flex-basis: 50%;
        }
        .workerTitle h1{
            color: #ffffff;
            font-size: 50px;
            text-shadow: rgba(0, 0, 0, 0.26) 3.95px 3.95px 7.6px;
        }
        .workerIllustrator{
            flex-basis: 50%;
            max-width: 540px;
            max-height: 540px;
        }
        .workerIllustrator img{
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: 0 auto;
        }
        @media (max-width: 870px) {
            .header{
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),url(../resources/attractive-brunet-man-stylish-white-shirt-trendy-sunglasses-poses-orange-background-holds-black-jacket.jpg);
                background-position: top;
                background-size: cover;
            }
            .workerIllustrator{
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="nav">
            <div class="logo"><h2>XFASSO<h2></div>
            <div class="admin">ADMIN</div>
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
</html>