<?php
require_once( __ROOT__."/data/dao.php");

class UserDAO extends DAO{

    function getFromDBByUserID($userID) {
        $parser = new class implements QueryProcesor {
            public function processRow($row) {
                $user = new User();
                $user->user_id = $row["id"];
                $user->user_name = $row["name"];
                $user->user_password = $row["managerID"];
                return $user;
            }
        };
        $query = 
        "SELECT * FROM ".DB::$DB_TABLE_USERS.
        " WHERE id='".$userID."' ";
        $users = $this -> db -> select( $query, $parser);
        if ( $users != null && count($users) > 0 ) {
            return $users[0];
        }else{
            return false;
        }
    }

    function saveUserIntoDB($userid, $name, $managerID) {
        
        $sql = "INSERT INTO ".DB::$DB_TABLE_USERS.
        " (id, name";
        
        $userManager = $managerID;
        if ( isset($managerID) && $managerID != "" ) {
            $sql .= ", managerID) ";
        } else {
            $sql .= ")";
        }
        $sql .= " VALUES (".
            "'$userid', '$name'";

        if ( isset($managerID) && $managerID != "") {
            $sql .= ", '$managerID'); ";
        } else {
            $sql .= ");";
        }
        // echo $sql;
        $this->db->insert($sql);
    }

}

?>