<?php

class DateParser {

    const SQLFORMAT = "Y-m-d";
    const APIFORMAT = "d-m-Y";
    const SQLFORMAT_DATETIME = "Y-m-d H:i:s";
    const APIFORMAT_DATETIME = "d-m-Y H:i";
    /**
     * 
     * will convert API date format that is dd-MM-yyyy
     * to SQL date format that is yyyy-mm-dd
     */
    public function date_fromAPItoSQL($apiDate){
        $phpdate = DateTime::createFromFormat(DateParser::APIFORMAT, $apiDate);
        return $phpdate -> format(DateParser::SQLFORMAT);
    }

    /**
     * 
     * will convert SQL date format that is YYYY-mm-dd  
     * to API date format that is dd-MM-yyyy
     */
    public function date_fromSQLtoAPI($sqlDate){
        $phpdate = DateTime::createFromFormat(DateParser::SQLFORMAT, $sqlDate);
        return $phpdate -> format(DateParser::APIFORMAT);
    }

    /**
     * 
     * will convert API date format that is dd-MM-yyyy
     * to SQL date format that is yyyy-mm-dd
     */
    public function dateTime_fromAPItoSQL($apiDate){
        try{
            $phpdate = $this ->dateTime_fromAPI($apiDate);
            return $phpdate -> format(DateParser::SQLFORMAT_DATETIME);
        }catch(Exception $ex){
            return null;
        }
    }

    /**
     * 
     * will convert SQL date format that is YYYY-mm-dd  
     * to API date format that is dd-MM-yyyy
     */
    public function dateTime_fromSQLtoAPI($sqlDate){
        $phpdate = $this->dateTime_fromSQL($sqlDate);
        return $phpdate -> format(DateParser::APIFORMAT_DATETIME);
    }

    public function dateTime_fromSQL($sqlDate) {
        return DateTime::createFromFormat(DateParser::SQLFORMAT_DATETIME, $sqlDate);
    }
    public function dateTime_fromAPI($apiDate) {
        return DateTime::createFromFormat(DateParser::APIFORMAT_DATETIME, $apiDate);
    }

    public function date_getNowInSQL() {
        return (new DateTime())->format(DateParser::SQLFORMAT);
    }

    public function date_getNowInAPI() {
        return (new DateTime())->format(DateParser::APIFORMAT);
    }
    public function dateTime_getNowInSQL() {
        return (new DateTime())->format(DateParser::SQLFORMAT_DATETIME);
    }

    public function dateTime_getNowInAPI() {
        return (new DateTime())->format(DateParser::APIFORMAT_DATETIME);
    }

    public function formatDateToSQL($dateTime) {
        return $dateTime->format(DateParser::SQLFORMAT);
    }

    public function formatDateToAPI($dateTime) {
        return $dateTime->format(DateParser::SQLFORMAT);
    }

    public function toSQLFromMILLIS($microseconds) {
        $dateTime = DateTime::createFromFormat('U.u', $microseconds);
        return $dateTime->format(DateParser::SQLFORMAT);
    }
}

?>