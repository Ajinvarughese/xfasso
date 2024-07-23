<?php

date_default_timezone_set("Asia/Calcutta");
echo "Today is " . date("Y/m/d") . "<br>";
echo "Today is " . date("Y.m.d") . "<br>";
echo "Today is " . date("Y-m-d") . "<br>";
echo "Today is " . date("l"). "<br>";
echo "The time is " . date("h:i:sa");

echo "<br><br>";
$content = file_get_contents('checkout.json');
$json = json_decode($content);

print_r($json);
echo "<br><br><br><br>";
$jsonDec = json_encode($json);
echo $jsonDec;

require '../UUID/UUID.php';
require_once '../connections/productdb.php';
$id = new UUID;
$uuid = $id->userID($conn);
echo $uuid;
?>  