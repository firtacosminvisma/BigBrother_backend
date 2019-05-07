<?php
require_once( __ROOT__."/data/dao.php");
require("Location.php");
require("UserWithLocation.php");

class LocationDAO extends DAO{

    function saveLocationIntoDB($userid, $latitude, $longitude) {
        
        $sql = "INSERT INTO ".DB::$DB_TABLE_LOCATIONS.
        " ( userID, latitude, longitude) VALUES ('"
        .$userid."','".$latitude."','".$longitude."'"
        .") ";
        $this->db->insert($sql);
    }


    function getLastLocationsForManagerTeam($managerID){
 
         $sql = "SELECT timeData.id as userID, timeData.time as timestamp, timeData.name, locations.latitude, locations.longitude FROM ".
         "(SELECT times.time, users.name, users.id from (SELECT MAX(timestamp) as time, userID from locations GROUP BY userID) as times  ".
         "JOIN users ON times.userID = users.id WHERE users.managerID = ".$managerID.") as timeData ".
         "JOIN locations on timeData.time = locations.timestamp and timeData.id = locations.userID";
         $locations = $this -> db -> select($sql, Location::parser());
         if ( $locations == null ){
             return [];
         }
         return $locations;

    }


    function getAllLocationsForTeam($managerID, $startDate, $endDate){
        //GET All the users from within the sent manager
        $sql = "SELECT * FROM users WHERE managerID=".$managerID;
        $users=$this->db->select($sql, UserWithLocations::userParser());
        //GET the locations for each user within the timestamps
        foreach ( $users as $user ) {
            $locationSQL = "SELECT * from locations WHERE userID='$user->id' AND timestamp>'$startDate' AND timestamp < '$endDate'";
            $locations = $this->db->select($locationSQL, Location::parser());
            $user->locations = $locations;
        }
        return $users;
    }
}

?>