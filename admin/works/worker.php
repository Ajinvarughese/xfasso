<?php 

function getWorkAPI(){
    require './works/Works.php';
    require '../connections/productdb.php';

    $quer = "SELECT * FROM admin";
    $res = mysqli_query($conn, $quer);

    if(mysqli_num_rows($res)>0) {
        $works = array(); 

        while($row = mysqli_fetch_assoc($res)) {
            $work = new Works($row['work'], $row['work_name']); 
            $works[] = $work;
        }
    }

    return $works;
}




function setWorkToJSON() {
    $data = array();
    foreach(getWorkAPI() as $work) {
        $data[] = array(
            "workID" => $work->getWorkID(),
            "workName" => $work->getWorkName()
        );
    }


    // Convert the array to JSON format
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    // Write the JSON data to the file
    $file_path = './work.json';
    file_put_contents($file_path, $json_data);
}

?>