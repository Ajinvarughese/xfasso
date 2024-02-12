<?php
require '../../connections/productdb.php';

$q = "SELECT * FROM products";
$r = mysqli_query($conn, $q);

$rating = array();
if(mysqli_num_rows($r) > 0) {
    while($res = mysqli_fetch_assoc($r)) {
        if($res['rating'] != NULL) {
            $rating[] = json_decode($res['rating'], true);
        }
    }

    echo json_encode($rating);
}
?>
