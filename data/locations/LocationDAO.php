<?php
require_once( __ROOT__."/data/dao.php");
require("Location.php");

class LocationDAO extends DAO{

    function saveLocationIntoDB($userid, $latitude, $longitude) {
        
        $sql = "INSERT INTO ".DB::$DB_TABLE_LOCATIONS.
        " ( userID, latitude, longitude) VALUES ("
        .$userid.",'".$latitude."','".$longitude."'"
        .") ";
        
        // echo $sql;
        $this->db->insert($sql);
    }


    function getLastLocationsForManagerTeam($managerID){
 
        /**
         
SELECT * FROM 
(SELECT * from 
	(SELECT MAX(timestamp) as time, userID from locations GROUP BY userID) as times 
     JOIN users ON times.userID = users.id WHERE users.managerID = 1
) as timeData 
  JOIN locations on timeData.time = locations.timestamp 
         
         */

         $sql = "SELECT * FROM (".
         "SELECT * from (".
            "SELECT MAX(timestamp) as time, userID from locations GROUP BY userID) as times ".
         " JOIN users ON times.userID = users.id WHERE users.managerID = ".$managerID.") as timeData".
         " JOIN locations on timeData.time = locations.timestamp ";
        //  echo $sql;
         $locations = $this -> db -> select($sql, Location::parser());
        //  print_r($locations);
         if ( $locations == null ){
             return [];
         }
         return $locations;

    }
}

?>