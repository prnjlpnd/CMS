<?php require_once("functions.php"); ?>
<?php require_once("sessions.php"); ?>
<?php

$_SESSION["User_Id"]=null;
session_destroy();
redirect_to("login.php");


 ?>