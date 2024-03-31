<?php 

 function errorPage($errorID, $redirect = false) {
    if($errorID == 1001) {
        return ("
            <div class='errorMain'>
                <div class='errorBlock'>
                    <div class='errorContent'>
                        <div class='image'>
                            <img src='../resources/NOproduct.jpg' alt='no product found'>
                        </div>
                        <div class='issue'>
                            <p >
                                The product you're looking for doens't exist.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        ");
    }
    else if($errorID == 1015) {
        return("
            <div class='errorMain'>
                <div class='errorBlock'>
                    <div class='errorContent'>
                        <div class='image'>
                            <img src='../resources/504.jpg' alt='Cannot send email'>
                        </div>
                        <div class='issue'>
                            <p>
                                Email not send. 
                                Check your internet connection and try again.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        ");
    }else if($errorID == 1025) {
        return("
            <div class='errorMain'>
                <div class='errorBlock'>
                    <div class='errorContent'>
                        <div class='image'>
                            <img src='../resources/504.jpg' alt='Cannot send email'>
                        </div>
                        <div class='issue'>
                            <p>
                                Can't connect to server. 
                                Check your internet connection and try again.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        ");
    }
    else if($errorID == 404 && $redirect) {
        return ("
            <script>
                window.location.href = '../404/';
            </script>
        ");
    }
 }
?>