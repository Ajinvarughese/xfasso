<?php 
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'productsdb';
    $conn = '';

    try {
        $conn = new mysqli($server, $user, $password, $db);
    }
    catch(mysqli_sql_exception) {
        die("Connection failed!");
    }
?>