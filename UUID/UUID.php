<?php 
class UUID {
    public function userID($conn) {  
        $quer = "SELECT user_id FROM users";
        $run = mysqli_query($conn, $quer);
        
        if(mysqli_num_rows($run) > 0) {
            $id = uniqid("jiK");
            $i=2292;
            while($res = mysqli_fetch_assoc($run)) {
                if($res['user_id'] === $id) {
                    $id = uniqid("a4m{$i}");
                    mysqli_data_seek($run, 0);
                    $i += rand(17, 423);
                    continue;
                }
            }
            
            return $id;
        } else {
            return uniqid("kWa");
        }
    }





    public function paymentID() {
        $quer = "SELECT payment_id FROM payments";
        $run = mysqli_query($conn, $quer);
        
        if(mysqli_num_rows($run) > 0) {
            $id = uniqid("gkq");
            $i=2292;
            while($res = mysqli_fetch_assoc($run)) {
                if($res['user_id'] === $id) {
                    $id = uniqid("qzW{$i}");
                    mysqli_data_seek($run, 0);
                    $i += rand(17, 423);
                    continue;
                }
            }
            
            return $id;
        } else {
            return uniqid("mAjn");
        }
    }

}

?>