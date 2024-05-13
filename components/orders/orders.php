<?php 



class Orders {
    private $order_id; 
    private $user_id;
    private $orderProduct;


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
        return $orderProduct['products'];
    }
    public function getUserDetails($orderProduct) {
        return $orderProduct['user'];
    }

}


?>