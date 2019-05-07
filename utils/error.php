<?php

class ErrorCodes {
    const REQUEST_TYPE_NOK = "100";
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