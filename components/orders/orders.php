<?php 

class Orders {
    private $order_id; 
    private $user_id;
    private $orderProduct;

    public $product_image;
    public $product_name;
    public $prize;
    public $quntity;
    public $size;

    public function __construct($order_id, $user_id, $orderProduct) {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->orderProduct = $orderProduct; 
    }
    
    public function getOrderProduct() {
        return $this->orderProduct;
    }
    public function getOrderId() {
        return $this->order_id;
    }
    public function getUserId() {
        return $this->user_id;
    }

    public function getProduct($orderProduct) {
        foreach($orderProduct['products'] as $p => $c) {
            foreach($c as $k => $s) {
                echo " $k => $s<br>";
            }
            // send this value to orders html page;
            echo "<br><br>";
        }
    }

}

?>