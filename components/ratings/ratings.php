<?php 
    require '../../connections/productdb.php';

    class Ratings {
        public $starCount;
        public $userId;
        public $description;

        public function __construct($starcount, $userId,$description) {
            $this->starCount = $starcount;
            $this->userId = $userId;
            $this->description = $description;
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