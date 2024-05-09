<?php 

    $server = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'xfasso';

    
    try {
        $conn = new mysqli($server, $user, $password, $db);
    }catch(mysqli_sql_exception) {
        echo "
            <script>
                window.location.href = '../errors/errors.php?errorID=1025';
            </script>
        ";
        die();
    }

?>