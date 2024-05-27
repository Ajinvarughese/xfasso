<?php 

    $DBSERVER = 'localhost';
    $DBUSER = 'root';
    $DBPASSWORD = '';
    $DB = 'xfasso';

    
    try {
        $conn = new mysqli($DBSERVER, $DBUSER, $DBPASSWORD, $DB);
    }catch(mysqli_sql_exception) {
        echo "
            <script>
                window.location.href = '../errors/errors.php?errorID=1025';
            </script>
        ";
        die();
    }

?>