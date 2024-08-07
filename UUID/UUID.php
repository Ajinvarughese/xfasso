<?php 
class UUID {
    public function __construct() {}
    
    private function generateUniqueID($code, $num) {
        $characters = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $id = '';
        $length = strlen($characters);

        // Append characters until the ID is at least 8 characters long
        while(strlen($id) < $num) {
            $id .= $characters[mt_rand(0, $length - 1)];
        }
        $finalID = $code.$id;
        return $finalID;
    }



    public function userID($conn) {  
        $quer = "SELECT user_id FROM users";
        $run = mysqli_query($conn, $quer);
        
        if(mysqli_num_rows($run) > 0) {
            $id = $this->generateUniqueID("xuser", 18);
            $i=2292;
            while($res = mysqli_fetch_assoc($run)) {
                if($res['user_id'] === $id) {
                    $id = $this->generateUniqueID("xuser{$i}", 18);
                    mysqli_data_seek($run, 0);
                    $i += rand(17, 423);
                    continue;
                }
            }
            
            return $id;
        } else {
            return $this->generateUniqueID("xuser", 18);
        }
    }

    public function paymentId($conn, $code, $num) {
        $quer = "SELECT payment_id FROM payments";
        $run = mysqli_query($conn, $quer);
        
        if(mysqli_num_rows($run) > 0) {
            $id = $this->generateUniqueID($code, $num);
            $i=2292;
            while($res = mysqli_fetch_assoc($run)) {
                if($res['payment_id'] === $id) {
                    $id = $this->generateUniqueID($code."{$i}", $num);
                    mysqli_data_seek($run, 0);
                    $i += rand(17, 423);
                    continue;
                }
            }
            
            return $id;
        } else {
            return $this->generateUniqueID($code, $num);
        }
    }


    public function orderID($conn, $code, $num) {
        $quer = "SELECT order_id FROM orders";
        $run = mysqli_query($conn, $quer);
        
        if(mysqli_num_rows($run) > 0) {
            $id = $this->generateUniqueID($code, $num);
            $i=2292;
            while($res = mysqli_fetch_assoc($run)) {
                if($res['order_id'] === $id) {
                    $id = $this->generateUniqueID($code."{$i}", $num);
                    mysqli_data_seek($run, 0);
                    $i += rand(17, 423);
                    continue;
                }
            }
            
            return $id;
        } else {
            return $this->generateUniqueID($code, $num);
        }
    }

}

?>