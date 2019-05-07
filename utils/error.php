<?php

class ErrorCodes {
    const REQUEST_TYPE_NOK = "100";
    const REQUEST_PARAMS_NOK = "101";
    const UNABLE_TO_EXECUTE_ACTION = "102";
    const TOKEN_EXPIRED_ERROR_CODE = "103";
    const TOKEN_NOT_IN_DB_ERROR_CODE = "104";
    const UNKNOWN_ERROR = "104";
    const TOKEN_CREATE_ERROR_CODE_1 = "111";
    const TOKEN_CREATE_ERROR_CODE_2 = "112";
    const TOKEN_REFRESH_ERROR_CODE_0 = "120";
    const TOKEN_REFRESH_ERROR_CODE_1 = "121";
    const TOKEN_REFRESH_ERROR_CODE_2 = "122";
    const TOKEN_REFRESH_ERROR_CODE_3 = "123";
}

class VVError {

    function createErrorResponse($errorCode, $errorType, $errorMessage) {
        $error = new stdClass();
        $error->error_code = $errorCode;
        $error->error_type = $errorType;
        $error->error_message = $errorMessage;
        return json_encode($error);
    }

    function createRequestTypeNOKError($neededMethod = "POST") {
        return $this -> createErrorResponse(
            ErrorCodes::REQUEST_TYPE_NOK, 
            "Request type error", 
            "This request is done via ".$neededMethod
        );
    }

    function createTokenExpiredError() {
        return $this -> createErrorResponse(
            ErrorCodes::TOKEN_EXPIRED_ERROR_CODE, 
            "Authentication error", 
            "The passed token is expired"
        );
    }

    function createTokenNotInDB(){
        return $this -> createErrorResponse(
            ErrorCodes::TOKEN_NOT_IN_DB_ERROR_CODE, 
            "Authentication error", 
            "The passed token is not recognized"
        );
    }

    function createUnknownError(){
        return $this -> createErrorResponse(
            ErrorCodes::UNKNOWN_ERROR, 
            "Unknown error", 
            "An unknown error has occurred."
        );
    }

    function tokenMissingError() {
        return $this->createRequestParamsNOKError("A `token` parameter is needed for this request.");
    }

    function createRequestParamsNOKError($appendics = "") {
        return $this -> createRequestParamsNOKErrorWithMessage("The parameters passed are not ok or should not exist.".$appendics);
    }
    
    function createRequestParamsNOKErrorWithMessage($message) {
        return $this -> createErrorResponse(
            ErrorCodes::REQUEST_PARAMS_NOK, 
            "Request params error", 
            $message
        );
    }

    function createUnableToExecuteAction($message) {
        return $this -> createErrorResponse(
            ErrorCodes::UNABLE_TO_EXECUTE_ACTION, 
            "Unable to execute action", 
            $message
        );
    }
}

?>