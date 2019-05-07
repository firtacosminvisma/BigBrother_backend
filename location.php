<?php
require_once "utils/defineRoot.php";
require "logic/locations/locationsLogic.php";
include_once 'utils/dateParser.php' ;
header("Content-type: application/json; charset=utf-8");
echo (new LocationLogic())->processRequest();
?>