<?php 
    require_once '../../connections/productdb.php';
    
    if(isset($_GET['workID'])) {

        $work_id = $_GET['workID'];

        $quer = "SELECT * FROM admin";
        $res = mysqli_query($conn, $quer);

        if(mysqli_num_rows($res)>0) {
            while($row = mysqli_fetch_assoc($res)) {
                if($row['work'] == $work_id){
                    echo $row['work'].'<br>'.$work_id;
                    $ID = $row['work'];
                    $workName = $row['work_name'];
                    echo $workName;
                    break;
                }
            }
        }
        header("Location: ./{$workName}/{$workName}.php");

    }else {
        header('Location: ../../404/');
    }

?>