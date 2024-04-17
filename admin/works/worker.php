<?php 

require './Works.php';
require '../../connections/productdb.php';

$quer = "SELECT * FROM admin";
$res = mysqli_query($conn, $quer);

if(mysqli_num_rows($res)>0) {
    while($row = mysqli_fetch_assoc($res)) {
        echo "workerID => ".$row['work'].'<br>';
        echo "workName => ".$row['work_name'].'<br><br>';
    }
}

?>