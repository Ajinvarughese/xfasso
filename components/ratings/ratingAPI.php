<?php

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    // Show 404 error
    header("Location: ../../errors/error.php?errorID=404");
    exit();
}

$q = "SELECT * FROM products";
$r = mysqli_query($conn, $q);

$rating = array();
if(mysqli_num_rows($r) > 0) {
    while($res = mysqli_fetch_assoc($r)) {
        if($res['rating'] != NULL) {
            $rating[] = json_decode($res['rating'], true);
        }
    }

    $ratingsOfProd = json_encode($rating);
}
?>
