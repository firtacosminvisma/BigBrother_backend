<?php

interface QueryProcesor {
    public function processRow($row);
}

class SQLError{
    static $SQL_ERROR_DUPLICATE_PRIMARY_KEY = 1062;

    public $errorCode;
    public $errorMessage;
}

class DB {
    static $DB_TABLE_USERS = "users";
    static $DB_TABLE_LOCATIONS = "locations";

    private $user = "28914temp_user";
    private $pass = "mobilemeetup";
    private $db = "vecinulvirtual_ro_bigbrother";
    private $server = "my23304.d28914.myhost.ro";

    private $connection;

    function connect() {
        $this->connection = new mysqli($this->server, $this->user, $this->pass, $this->db);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
            return false;
        } 
        /* change character set to utf8 */
        if (!$this->connection->set_charset("utf8")) {
            printf("Error loading character set utf8: %s\n", $this->connection->error);
        } 
        echo "connected";
        return true;
    }

    function closeConnection() {
        $this->connection->close();
    }

    function select($query, QueryProcesor $procesor) {
        if ($this -> connect()) {
            $result = $this->connection->query($query);
            if ( !empty($result) ){ 
                $resultValues = array();
                if ($result->num_rows > 0) {
                    if ( $result->num_rows == 1 ) {
                        /** if only one row then there might be an error */
                        /** check for it */
                        $row = $result->fetch_assoc();
                        $error = $this->checkForErrorInRow($row);
                        if ( $error == null ){
                            array_push($resultValues, $procesor->processRow($row));
                        } else {
                            $resultValues = $error;
                        }
                    }else{
                        /* if there are more then one element then it's most defenetly not an error*/
                        while($row = $result->fetch_assoc()) {
                            array_push($resultValues, $procesor->processRow($row));
                        }
                    }
                }else {
                    $resultValues = null;       
                }
            } else {
                //sql got nothing
                $resultValues = null;
            }
            $this -> connection -> close();
            return $resultValues;
        }
    }

    function selectOneValue($query) {
        if ($this -> connect()) {
            $result = $this->connection->query($query);
            if ( !empty($result) ){ 
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $resultValues = $row[0];
                    }
                }else{
                    $resultValues = null;
                }
            } else {
                //sql got nothing
                $resultValues = null;
            }
            $this -> connection -> close();
            return $resultValues;
        }
    }

    function insert($query) {
        if ($this -> connect()) {
            $result = $this->connection->query($query);
            $this -> connection -> close();
            if ($result === TRUE) {
                // print_r($result);
                return true;
            } else {
                return false;            
            }
        }
    }

    function update($query) {
        if ($this -> connect()) {
            $result = $this->connection->query($query);
            $this -> connection -> close();
            if ($result === TRUE) {
                return true;
            } else {
                return false;            
            }
        }
    }


    private function checkForErrorInRow($row) {
        $error = new SQLError();
        if ( isset($row['error']) && $row['error'] != null ) {
            $error->errorMessage = $row['error'];
            if ( isset($row['errCode']) ) {
                $error->errorCode = $row['errCode'];
            }
            return $error;
        }
        return null;
    }
}

?>