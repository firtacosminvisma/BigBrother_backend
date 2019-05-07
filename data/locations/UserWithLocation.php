<?php

class UserWithLocations implements JsonSerializable{
    public $name;
    public $id;
    public $locations;
    public $locationCounts = 0;
    
    public static function userParser() {
        return new class implements QueryProcesor {
            public function processRow($row) {
                $user = new UserWithLocations();
                $user->name = $row["name"];
                $user->id = $row["id"];
                $user->locationCounts = 0;
                return $user;
            }
        };
    }
    
    public static function locationsParser() {
        return new class implements QueryProcesor {
            public function processRow($row) {
                $this->$locations[$this->locationCounts]->latitude = $row["latitude"];
                $this->$locations[$this->locationCounts]->longitude = $row["longitude"];
                $this->$locations[$this->locationCounts]->timestamp = $row["timestamp"];
                $this->locationCounts ++;
                return $user;
            }
        };
    }
    
    /**
     * method that will parse the object into a JSON serializable object.
     * It is called when json_encode function is called
     */
    public function jsonSerialize() {
        $retVal = [
            'name' => htmlentities($this->name),
            'userID' => htmlentities($this->id),
            'locations' => []
        ];
        foreach ( $this->locations as $location ) {
            array_push($retVal['locations'],[
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'timestamp' => $location->timestamp
            ]);
        }
        return $retVal;
    }
}

?>