<?php
require_once(__ROOT__.'/utils/error.php'); 

class Logic {

    /** @var VVError error the error manager */
    protected $error;

    public function __construct() {
        $this->error = new VVError();
    }

    protected function fetchGetParam($paramName, $defaultValue = null){
        return $_GET[$paramName] ?? $defaultValue;
    }

    protected function getJsonObjectFromBody() {
        
        # Get JSON as a string
        $json_str = file_get_contents('php://input');
        # Get as an object
        return json_decode($json_str);  
    }
}

?>