<?php

require_once(__ROOT__.'/utils/error.php'); 
include_once __ROOT__.'/utils/dateParser.php'; 
require_once(__ROOT__.'/logic/Logic.php'); 
require_once(__ROOT__.'/data/user/userDAO.php'); 



class UserLogic  extends Logic {

    /** @var UserDataDAO userDataDAO the variable helps acces the user data database */
    private $userDAO;

    const USER_ID_PARAM = "userID";
    const LATITUDE_PARAM = "lattitude";
    const LONGITUDE_PARAM = "longitude";
    const ID_PARAM = "id";
    const NAME_PARAM = "name";
    const MANAGER_ID_PARAM = "managerID";

    function __construct(){
        parent::__construct();
        $this->userDAO = new UserDAO();
    }

    function processRequest() {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
            return $this->postUser();
        }else{
            //send error because the method is not POST
            http_response_code(400);
            return $this -> error -> createRequestTypeNOKError(" POST ");
        }
    }

    private function postUser() {
        $bodyObj = json_decode(file_get_contents('php://input'));
        $bodyError = $this->checkForParamError($bodyObj);
        if ( empty($bodyError) ){
            $this->userDAO->saveUserIntoDB(
                $bodyObj->id,
                $bodyObj->name,
                $bodyObj->managerID   
            );
            return '{"response":"OK"}';
            
        }else{
            return $bodyError;
        }
    }

    private function checkForParamError($json_obj){
        $paramError = "";
        if ( empty($json_obj->name) ) {
            $paramError .= " 'name' ";
        }
        if ( empty($json_obj->id) ) {
            $paramError .= " 'id' ";
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