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

    <div id="main" class="main">
        <div class="header">
            <h1 align='center'>Add new products from here</h1>
            <p id="warning" align='center' style="margin-top: 10px; font-size: 12px; color: red;"></p>
        </div>
        <div class="fjs">
            <style>
                
            </style>
            <form action="send/send.php" method="post" enctype="multipart/form-data">

                <div class="pew">
                    <input class="in i" name="prod_name" type="text" placeholder="Name">
                </div>
                <div class="pew">
                    <input class="in i" name="prod_id" type="text" placeholder="Product ID">
                </div>
                <div class="pew">
                    <input class="in i" name="prod_price" type="text" placeholder="Price">
                </div>
                
                <div class="pew">
                    <textarea style="resize: none;" class="in" name="description" id="txt" rows="6" placeholder="Description..." ></textarea>
                </div>

                <div class="pew">
                    <select name="gender" id="gender">
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                    </select>
                </div>

                <div class="pew">
                    <p class='pq3'>Main image:</p>
                    <div class="prodImage">
                        <div id="file-preview1" class="file-preview">Image required</div>
                        <input name="img1" type="file" id="file-input1" class="file-input" accept="image/*" onchange="displayImage(this, 1)">
                        <label for="file-input1" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="pew">
                    <p class='pq3'>Right image:</p>
                    <div class="prodImage">
                        <div id="file-preview2" class="file-preview">Image required</div>
                        <input name="img2" type="file" id="file-input2" class="file-input" accept="image/*" onchange="displayImage(this, 2)">
                        <label for="file-input2" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="pew">
                    <p class='pq3'>Left image:</p>
                    <div class="prodImage">
                        <div id="file-preview3" class="file-preview">Image required</div>
                        <input name="img3" type="file" id="file-input3" class="file-input" accept="image/*" onchange="displayImage(this, 3)">
                        <label for="file-input3" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="pew">
                    <p class='pq3'>Back image:</p>
                    <div class="prodImage">
                        <div id="file-preview4" class="file-preview">Image required</div>
                        <input name="img4" type="file" id="file-input4" class="file-input" accept="image/*" onchange="displayImage(this, 4)">
                        <label for="file-input4" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="pw"> 
                    <div onclick="reset()" class="btn sec">Reset</div>
                    <div onclick="submit()" class="btn pri">Submit</div>
                </div>

                <div id="warningReset" class="warningReset">
                    <div class="ask">
                        <div class="imgDiv1">
                            <div class="img">
                                <img src="../../images/reset.png" alt="reset">
                            </div>
                        </div>
                        <div class="content">
                            <h1>Do you want to reset?</h1>
                            <p align='center'>Are you sure you want to reset all the input fields.</p>
                            <br>
                            <div class="btna" id="conReset">Reset</div>
                        </div>
                    </div>
                </div>

                <div id="warningSubmit" class="warningReset">
                    <div class="ask">
                        <div class="imgDiv2">
                            <div class="img">
                                <img src="../../images/tick.png" alt="reset">
                            </div>
                        </div>
                        <div class="content">
                            <h1>Do you want to submit?</h1>
                            <p align='center'>Are you sure you want to submit the new product to store.</p>
                            <br>
                            <button class="btna" name="submit" value="false" onclick="validForm(this)" id="conSubmit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validForm(e) {
            e.value = true;
        }
        function reset() {
            let warningReset = document.getElementById('warningReset');
            if(warningReset.style.display == 'block'){
                warningReset.style.display = 'none';
            }else {
                warningReset.style.display = 'block';
                window.location.href = '#main';
            }
        }

        function submit() {
            let warningSubmit = document.getElementById('warningSubmit');
            if(warningSubmit.style.display == 'block'){
                warningSubmit.style.display = 'none';
            }else {
                warningSubmit.style.display = 'block';
                window.location.href = '#main';
            }
        }

        let confirmReset = document.getElementById('conReset');
        confirmReset.addEventListener('click', ()=> {
            window.location.reload();
        })
        

        // function displayImage(input, num) {
        //     const fileInput = document.getElementById(`file-input${num}`);
        //     const filePreview = document.getElementById(`file-preview${num}`);

        //     if (fileInput.files && fileInput.files.length > 0) {
        //         const file = fileInput.files[0];
        //         const reader = new FileReader();

        //         reader.onload = function(e) {
        //             filePreview.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image" class="preview-image">`;
        //         }

        //         reader.readAsDataURL(file);
        //     } else {
        //         filePreview.innerHTML = "";
        //     }
        // }
    </script>
    <?php 

        if(isset($_SESSION['productAdded'])) {
            if($_SESSION['productAdded'] != false) {
                echo "
                    <script>
                        let warn = document.getElementById('warning');
                        warn.innerHTML = 'Product added successfully.';
                        warn.style.color = 'green';
                        setTimeout(()=> {
                            warn.innerHTML = '';
                            warn.style.color = 'red';
                        }, 7000)
                    </script>
                ";
                $_SESSION['productAdded'] = false;
            }
        }

        if(isset($_SESSION['noInput'])) {
            if($_SESSION['noInput'] != false) {
                echo "
                    <script>
                        let warn = document.getElementById('warning');
                        warn.innerHTML = 'Failed adding product. Please fill out all input fields.';
                        setTimeout(()=> {
                            warn.innerHTML = '';
                        }, 7000)
                    </script>

                ";
                $_SESSION['noInput'] = false;
            }
        }
    ?>
</body>
<script src="../main.js"></script>
</html>