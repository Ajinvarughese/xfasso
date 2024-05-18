<?php 
include '../../connections/sendMail.php';


$sender = "xfassofashion@gmail.com";
$reciver = "ajinvarughese91@gmail.com";
$message = "Hey it's a test number 1";
$subject = "test";
$path = '../../';
sendMail($sender, $reciver, $message, $subject, $path);

?>