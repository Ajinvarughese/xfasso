<?php 
    session_start();
    require_once '../../../connections/productdb.php';
    
    if(empty($_SESSION['XQCLANG'])){
        header('Location: ../../admin-login/');
    }

    if(isset($_SESSION['failureprodID'])) {
        $prodID = $_SESSION['failureprodID'];
        $_SESSION['failureprodID'] == NULL;
    }else if(isset($_SESSION['successedID'])){
        $prodID = $_SESSION['successedID'];
        $_SESSION['successedID'] = NULL;
    }
    else {
        foreach($_POST as $p => $v) {
            if(isset($p)) {
                $prodID = $v;
                break;
            }
        }
    }

    if(empty($prodID)){
        header('Location: ./productEdit.php');
    }

    $prodID = mysqli_escape_string($conn, $prodID);
    
    $quer = "SELECT * FROM products INNER JOIN product_images ON products.product_id = product_images.product_id WHERE products.product_id = {$prodID}";
    if($run = mysqli_query($conn, $quer)) {
        if(mysqli_num_rows($run)>0) {
            $row=mysqli_fetch_assoc($run);  
            
            $productName = $row['product_name'];
            $prodID = $row['product_id'];
            $price = $row['product_price'];
            $desc = $row['product_desc'];
            $gender = $row['product_gender'];
            
            $imageMain = base64_encode($row['product_image']);
            $imageBack = base64_encode($row['img_back']);
            $imageRight = base64_encode($row['img_right']);
            $imageLeft = base64_encode($row['img_left']);

            $imageType = "image/jpeg";
        }else {
            $quer = "SELECT * FROM products WHERE product_id = {$prodID}";
            $run = mysqli_query($conn, $quer);
            $row=mysqli_fetch_assoc($run);

            $imageType = "image/jpeg";
            
            $productName = isset($row['product_name'])?$row['product_name']: "";
            $prodID = isset($row['product_id'])?$row['product_id']: "";
            $price = isset($row['product_price'])?$row['product_price']: "";
            $desc = isset($row['product_desc'])?$row['product_desc']: "";
            $gender = isset($row['product_gender'])?$row['product_gender']: "";
            
            $imageMain = isset($row['product_image'])?base64_encode($row['product_image']): "";
            $imageBack = isset($row['img_back'])?base64_encode($row['img_back']): "";
            $imageRight = isset($row['img_right'])?base64_encode($row['img_right']): "";
            $imageLeft = isset($row['img_left'])?base64_encode($row['img_left']): "";        
        }
    }
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products</title>


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
            <h1 align='center'>Edit the products from here</h1>
            <p id="warning" align='center' style="margin-top: 10px; font-size: 12px; color: red;"></p>
        </div>
        <div class="fjs">
            <style>
                #prodID {
                    cursor: default;
                }
                #prodID:focus {
                    outline: none;
                    border: 1px solid #c2c2c2c2;
                    caret-color: transparent;
                }
            </style>
            <form action="./send/send.php" method="post" enctype="multipart/form-data">
                <div class="pew">
                    <p class="pla">ID: </p>
                    <input id="prodID" class="in i" name="prod_id" type="text" placeholder="Product ID">
                    <script>
                        let prodID = document.getElementById("prodID");
                        prodID.value = `<?php echo $prodID;?>`;
                        prodID.addEventListener('input', ()=> {
                            prodID.value=`<?php echo $prodID?>`;
                        });
                    </script>
                </div>
                <div class="pew">
                    <p class="pla">Name: </p>
                    <input class="in i" name="prod_name" type="text" placeholder="Name" value="<?php echo $productName;?>">
                </div>
                <div class="pew">
                    <p class="pla">Price: </p>
                    <input class="in i" name="prod_price" type="text" placeholder="Price" value="<?php echo $price?>">
                </div>
                
                <div class="pew">
                    <p class="pla">Description: </p>
                    <textarea style="resize: none;" class="in" name="description" id="txt" rows="6" placeholder="Description..."><?php echo $desc?></textarea>
                </div>
                <div class="pew">
                    <select name="gender" id="gender">
                        <?php 
                            if($gender =='men') {
                                echo "
                                    <option value='men'>Men</option>
                                    <option value='women'>Women</option>
                                ";
                            }else {
                                echo "
                                    <option value='women'>Women</option>
                                    <option value='men'>Men</option>
                                ";
                            }
                        ?>
                    </select>
                </div>

                <div class="paw pew">
                    <p class='pq3'>Main image:</p>
                    <div class="prodImage">
                        <div id="file-preview1" class="file-preview"><img <?php echo "src='data:$imageType;base64,$imageMain'"; ?> alt="Uploaded Image" class="preview-image"></div>
                        <input name="img1" type="file" id="file-input1" class="file-input" accept="image/*" onchange="displayImage(this, 1)">
                        <label for="file-input1" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="paw pew">
                    <p class='pq3'>Right image:</p>
                    <div class="prodImage">
                        <div id="file-preview2" class="file-preview"><img <?php echo "src='data:$imageType;base64,$imageRight'"; ?> alt="Uploaded Image" class="preview-image" onerror="hide('file-preview2')"></div>
                        <input name="img2" type="file" id="file-input2" class="file-input" accept="image/*" onchange="displayImage(this, 2)">
                        <label for="file-input2" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="paw pew">
                    <p class='pq3'>Left image:</p>
                    <div class="prodImage">
                        <div id="file-preview3" class="file-preview"><img <?php echo "src='data:$imageType;base64,$imageLeft'"; ?> onerror="hide('file-preview3')" alt="Uploaded Image" class="preview-image"></div>
                        <input name="img3" type="file" id="file-input3" class="file-input" accept="image/*" onchange="displayImage(this, 3)">
                        <label for="file-input3" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="paw pew">
                    <p class='pq3'>Back image:</p>
                    <div class="prodImage">
                        <div id="file-preview4" class="file-preview"><img <?php echo "src='data:$imageType;base64,$imageBack'"; ?> onerror="hide('file-preview4')" alt="Uploaded Image" class="preview-image"></div>
                        <input name="img4" type="file" id="file-input4" class="file-input" accept="image/*" onchange="displayImage(this, 4)">
                        <label for="file-input4" class="custom-file-upload">Choose Image</label>
                    </div>
                </div>

                <div class="pw paw"> 
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
        function hide(idInp) {
            let id = document.getElementById(idInp);
            id.innerHTML = "Image required";
        }
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
        

        function displayImage(input, num) {
            const fileInput = document.getElementById(`file-input${num}`);
            const filePreview = document.getElementById(`file-preview${num}`);

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
    <?php 

        if(isset($_SESSION['productAdded'])) {
            if($_SESSION['productAdded'] != false) {
                echo "
                    <script>
                        let warn = document.getElementById('warning');
                        warn.innerHTML = 'Product edited successfully.';
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
                        warn.innerHTML = 'Product editing failed. Please fill out all the fields or contact the executer';
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