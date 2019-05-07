<?php

$host["bigbrother"] = "bigbrother.ro";
$host["localhost"] = "localhost";

// print_r($_SERVER);

if ( $_SERVER["SERVER_NAME"] == $host["api"]  ) {
    define('__ROOT__', $_SERVER['DOCUMENT_ROOT']."/.."); 
} else if ( $_SERVER["SERVER_NAME"] == $host["bigbrother"] ) {
    define('__ROOT__', $_SERVER['DOCUMENT_ROOT']); 
} else if ( $_SERVER["SERVER_NAME"] == $host["localhost"]){
    define('__ROOT__', $_SERVER['DOCUMENT_ROOT']."/bigbrother");
}
// echo "<br/>";echo "<br/>";
// echo $_SERVER["SERVER_NAME"];
// echo "<br/>";
// echo __ROOT__;

?>