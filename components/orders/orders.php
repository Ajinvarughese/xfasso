<?php 

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    // Show 404 error
    header("Location: ../../errors/errors.php?errorID=404");
    exit();
}

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
        return $orderProduct['products'];
    }
    public function getUserDetails($orderProduct) {

        return $orderProduct['user'];
    }

}


// {
//     "product_id": "556"
//   },
//   {
//     "product_name": "Louis"
//   },
//   {
//     "product_price": "599"
//   },
//   {
//     "quantity": "1"
//   },
//   {
//     "size": "XL"
//   },
//   {
//     "product_id": "555"
//   },
//   {
//     "product_name": "Mule"
//   },
//   {
//     "product_price": "899"
//   },
//   {
//     "quantity": "2"
//   },
//   {
//     "size": "L"
//   }
?>