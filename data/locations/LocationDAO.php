<?php
require_once( __ROOT__."/data/dao.php");

class LocationDAO extends DAO{

    function saveLocationIntoDB($userid, $latitude, $longitude) {
        
        $sql = "INSERT INTO ".DB::$DB_TABLE_LOCATIONS.
        " ( userID, latitude, longitude) VALUES ("
        .$userid.",'".$latitude."','".$longitude."'"
        .") ";
        
        
        echo $sql;
        $this->db->insert($sql);
    }

}

?>