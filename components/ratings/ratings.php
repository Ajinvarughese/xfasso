<?php 
    require '../../connections/productdb.php';

    class Ratings {
        public $starCount;
        public $userId;
        public $description;

        public $product_id;

        public function __construct($product_id, $starcount, $userId,$description) {
            $this->starCount = $starcount;
            $this->userId = $userId;
            $this->description = $description;
            $this->product_id = $product_id;
        }

        public function getProductID() {
            return $this->starCount;
        }
        public function setProductID($prodId) {
            $this->product_id = $prodId; 
        }

        public function getCount() {
            return $this->starCount;
        }
        public function setCount($count) {
            $this->starCount = $count; 
        }

        public function getUser() {
            return $this->userId;
        }
        public function setUser($user) {
            $this->userId = $user; 
        }

        public function getDesc() {
            return $this->description;
        }
        public function setDesc($desc) {
            $this->description = $desc; 
        }
    }
?>