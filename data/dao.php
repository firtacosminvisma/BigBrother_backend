<?php

require_once( __ROOT__."/utils/db.php");

class DAO {

    protected $db;

    public function __construct() {
        $this->db = new DB();
    }
}
?>