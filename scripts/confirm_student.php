<?php
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('../connection/connector.php');
		require_once('../config.php');

		main::setEncoding();
		
		$studentsid = htmlspecialchars($_GET['id']);
		$classid = htmlspecialchars($_GET['classid']);
		$connect = new DbConnector();
		
		$oMain = new main;
		$teacherid =  $oMain->get_teacherid($_SESSION['username']);
		$oKlas = new klas;
		
		if($oKlas->checkKlasen($teacherid, $classid))
		{
			$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET checked = 'true' WHERE studentsid = '$studentsid'") or die(MYSQL_ERROR);
			if($query)
			{
				echo '<font color="green">Yes</font>';
			}
		}
	}
	else {
		header('Location: index.php');
	}
?>