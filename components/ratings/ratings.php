<?php 
    
    require '../../connections/productdb.php';

    

    class Ratings {
        private $product_id;
        private $starCount;
        private $userId;
        private $description;
        private $day;

        public function __construct($product_id, $starcount, $userId, $description, $day) {
            $this->product_id = $product_id;
            $this->starCount = $starcount;
            $this->userId = $userId;
            $this->description = $description;
            $this->day = $day;
        }

        public function getDay() {
            return $this->day;
        }
        public function setDay($day) {
            $this->day = $day; 
        }


        public function getProductID() {
            return $this->product_id;
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