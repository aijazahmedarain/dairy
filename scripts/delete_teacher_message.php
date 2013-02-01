<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'teacher'))
	{
		require_once('../connection/connector.php');
		require_once('../functions.php');
		require_once('../config.php');
		
		main::setEncoding();
		
		$connect = new DbConnector();
		
		$oMain = new main;
		$teacherid = $oMain->get_teacherid($_SESSION['username']);
		
		$id = addslashes($_GET['id']);
		
		$check = $connect->query("SELECT id FROM ".$TABLES['teacher_messages']." WHERE teacherid = '$teacherid' && id = '$id'")or die(MYSQL_ERROR);
		
		if($connect->numRows($check))
		{
			$delete = $connect->query("DELETE FROM ".$TABLES['teacher_messages']." WHERE id = '$id'")or die(MYSQL_ERROR);
			
			if($delete)
			{
				echo '<div id="success">Successfully deleted message!</div>';
			}
		}
		else {
			echo '<font color="red">Error</font>';
		}
	}
	else {
		header('Location: index.php');
	}
?>
