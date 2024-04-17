<?php 


if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    // Show 404 error
    header("Location: ../../404/");
    exit();
}


class Works {
    private $workID;
    private $workName;

    public function __construct($workID, $workName) {
        $this->workID = $workID;
        $this->workName = $workName;
    }

    public function setWorkID($workID) {
        $this->workID = $workID;
    }
    public function getWorkID() {
        return $this->workID;
    }

    public function setWorkName($workName) {
        $this->workName = $workName;
    }
    public function getWorkName() {
        return $this->workName;
    }
}


?>