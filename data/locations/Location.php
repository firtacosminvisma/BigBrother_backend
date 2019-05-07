<?php

class Location implements JsonSerializable{
    public $userID;
    public $name;
    public $latitude;
    public $longitude;
    public $timestamp;
    /**
     * method used to parse a database row into a Service object
     */
    public static function parser() {
        return new class implements QueryProcesor {
            public function processRow($row) {
                $location = new Location();
                $location->userID = $row["userID"];
                $location->name = $row["name"];
                $location->latitude = $row["latitude"];
                $location->longitude = $row["longitude"];
                $location->timestamp = $row["timestamp"];
                return $location;
            }
        };
    }
    /**
     * method that will parse the object into a JSON serializable object.
     * It is called when json_encode function is called
     */
    public function jsonSerialize() {
        $retVal = [
            'userID' => htmlentities($this->userID),
            'name' => htmlentities($this->name),
            'latitude' => htmlentities($this->latitude),
            'longitude' => htmlentities($this->longitude),
            'timestamp' => htmlentities($this->timestamp)
        ];
        // print_r($retVal);
        return $retVal;
    }
}

?>