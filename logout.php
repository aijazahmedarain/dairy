<?php
session_start();

require_once('connection/connector.php');
require_once('config.php');
	
$connect = new DbConnector();

$username = $_SESSION['username'];

$query = $connect->query("UPDATE ".$TABLES['users']." SET online = 'false' where username = '$username'");

$_SESSION["username"] = "";

$_SESSION["password"] = "";

$_SESSION["user_rank"] = "";

if($_SESSION['loggedin'])
{
	$_SESSION["loggedin"] = false;
}
if($_SESSION["loggedin_student"])
{
	$_SESSION["loggedin_student"] = false;
}

header("Location: ".$_GET['goback']);

?> 