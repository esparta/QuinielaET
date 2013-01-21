<?php 
@include_once("include/config-local.php");

session_start();
session_unset();
$_SESSION = array();
session_destroy();
session_write_close();

header("Location: index.php");
exit();

?>