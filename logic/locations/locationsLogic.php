<?php

require_once(__ROOT__.'/utils/error.php'); 
include_once __ROOT__.'/utils/dateParser.php'; 
require_once(__ROOT__.'/logic/Logic.php'); 
require_once(__ROOT__.'/data/locations/LocationDAO.php'); 



class LocationLogic  extends Logic {

    private $locationDAO;

    const USER_ID_PARAM = "userID";
    const LATITUDE_PARAM = "lattitude";
    const LONGITUDE_PARAM = "longitude";
    const ID_PARAM = "id";
    const NAME_PARAM = "name";
    const MANAGER_ID_PARAM = "managerID";
    /**
     
        {
			"userID": "<USER ID NO>",
			"lattitude": "",
			"longitude": ""
        }
        
     */

    function __construct(){
        parent::__construct();
        $this->locationDAO = new LocationDAO();
    }

    function processRequest() {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
            return $this->postLocation();
        }else{
            //send error because the method is not POST
            http_response_code(400);
            return $this -> error -> createRequestTypeNOKError(" POST ");
        }
    }

    function processGetLastLocation(){
        if ( $_SERVER["REQUEST_METHOD"] == "GET" ) {
            return $this->getLastLocation();
        }else{
            //send error because the method is not POST
            http_response_code(400);
            return $this -> error -> createRequestTypeNOKError(" GET ");
        }
    }

    function processGetAllLocationsForTeam(){
        if ( $_SERVER["REQUEST_METHOD"] == "GET" ) {
            return $this->getAllLocationsForTeam();
        }else{
            //send error because the method is not POST
            http_response_code(400);
            return $this -> error -> createRequestTypeNOKError(" GET ");
        }
    }

    private function postLocation() {
        $bodyObj = json_decode(file_get_contents('php://input'));
        $bodyError = $this->checkForParamError($bodyObj);
        if ( empty($bodyError) ){
            $this->locationDAO->saveLocationIntoDB(
                $bodyObj->userID,
                $bodyObj->lattitude,
                $bodyObj->longitude   
            );
            return '{"response":"OK"}';
            
        }else{
            return $bodyError;
        }
    }

    private function getAllLocationsForTeam() {
        $bodyError = $this->checkForGetAllLocationsParamError();
        if ( empty($bodyError) ){
            $result = $this->locationDAO->getAllLocationsForTeam(
                $_GET["managerID"],
                $_GET["startTimeStamp"],
                $_GET["endTimeStamp"]
            );
            $returnObject->response = "OK";
            $returnObject->users=$result;
            $ret = json_encode($returnObject);
            return $ret;
            
        }else{
            return $bodyError;
        }
    }

    private function getLastLocation() {
        
        $managerID = $_GET["managerID"];
        if ( !isset($managerID) || $managerID == "" ){
            $errorMsj = "The following parameters are missing: managerID";
            return $this->error->createRequestParamsNOKError($errorMsj);
        }else{
            $result = $this->locationDAO->getLastLocationsForManagerTeam($_GET["managerID"]);
            $returnObject->response = "OK";
            $returnObject->users=$result;
            $ret = json_encode($returnObject);
            return $ret;
        }
            
            
    }

    private function checkForParamError($json_obj){
        $paramError = "";
        if ( empty($json_obj->userID) ) {
            $paramError .= " 'userID' ";
        }
        if ( empty($json_obj->lattitude) ) {
            $paramError .= " 'lattitude' ";
        }
        if ( empty($json_obj->longitude) ) {
            $paramError .= " 'longitude' ";
        }

        if ( !empty($paramError) ) {
            $errorMsj = "The following parameters are missing: ".$paramError;
            return $this->error->createRequestParamsNOKError($errorMsj);
        }else{
            return "";
        }
    }

    private function checkForGetAllLocationsParamError() {
        $paramError = "";
        if ( empty($_GET["managerID"]) ) {
            $paramError .= " 'managerID' ";
        }
        if ( empty($_GET["startTimeStamp"]) ) {
            $paramError .= " 'startTimeStamp' ";
        }
        if ( empty($_GET["endTimeStamp"]) ) {
            $paramError .= " 'endTimeStamp' ";
        }

        if ( !empty($paramError) ) {
            $errorMsj = "The following parameters are missing: ".$paramError;
            return $this->error->createRequestParamsNOKError($errorMsj);
        }else{
            return "";
        }
    }
}

?>