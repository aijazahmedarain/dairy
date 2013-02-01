<?php	
	session_start();
	error_reporting(0); 
	if($_SESSION['loggedin'] == false || ($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin' || $_SESSION['user_rank'] == 'teacher')))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		main::setEncoding();
		
		$username = htmlspecialchars($_GET['username']);
		
		$oRegister = new register;
		$oRegister->username = $username;
		$oRegister->returnTrueResult = true;
		$oRegister->usernameValidation();
	}
	else {
		header('Location: index.php');
	}
?>