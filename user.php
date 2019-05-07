<?php
require_once "utils/defineRoot.php";
require "logic/userLogic.php";
include_once 'utils/dateParser.php' ;
header("Content-type: application/json; charset=utf-8");
echo (new UserLogic())->processRequest();
?>