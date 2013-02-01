<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		$connect = new DbConnector();
		
		$oMain = new main;
		$oMain->setEncoding();
		
		$teacherid = addslashes($_GET['teacherid']);
		$classid = addslashes($_GET['classid']);

		if(is_numeric($teacherid) && $teacherid >= 1 && is_numeric($classid) && $classid >= 1 && $oMain->checkTeacherid($teacherid))
		{
			$select = $connect->query("SELECT teacherid FROM ".$TABLES['klasen']." WHERE classid = '".mysql_real_escape_string($classid)."'");
			
			if($connect->numRows($select))
			{
				$query = $connect->query("UPDATE ".$TABLES['klasen']." SET teacherid = '$teacherid' WHERE classid = '".mysql_real_escape_string($classid)."'");
				
				if($query)
				{
					echo '<div align="center"><div id="success">Successfully set form-master!</div></div><br />';
				}
			}
			else {
				$query1 = $connect->query("INSERT INTO ".$TABLES['klasen']." (classid, teacherid) VALUES('$classid', '$teacherid')");
				
				if($query1)
				{
					echo '<div align="center"><div id="success">Successfully added form-master!</div></div><br />';
				}
			}
		}
		else {
			echo '<div align="center"><div id="error">Select a valid teacher!</div></div><br />';
		}
	}
	else {
		header('Location: index.php');
	}
?>