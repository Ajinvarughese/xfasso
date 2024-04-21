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
    <title>Add Products</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">       

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        .file-input {
            display: none;
        }
        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .file-preview {
            margin-top: 20px;
            width: 62px;
            height: 62px;
        }
        .file-preview img {
            max-width: 100%;
            max-height: 100%;
            display: block;
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

    <div class="main">
        <div class="header">
            <h1 align='center'>Add new products from here</h1>
        </div>
        <div class="fjs">
            <form action="" method="post">
                <div class="prodImage">
                    <input type="file" id="file-input" class="file-input" accept="image/*" onchange="displayImage(this)">
                    <label for="file-input" class="custom-file-upload">Choose Image</label>
                    <div id="file-preview" class="file-preview"></div>
                </div>

            </form>
        </div>
    </div>
    <script>
        function displayImage(input) {
            const fileInput = document.getElementById('file-input');
            const filePreview = document.getElementById('file-preview');

            if (fileInput.files && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    filePreview.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image" class="preview-image">`;
                }

                reader.readAsDataURL(file);
            } else {
                filePreview.innerHTML = "";
            }
        }
    </script>
</body>
<script src="../main.js"></script>
</html>