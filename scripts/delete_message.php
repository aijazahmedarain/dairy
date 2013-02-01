<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');

		main::setEncoding();
		
		$id = htmlspecialchars($_GET['id']);

		$connect = new DbConnector();
					
		$delete = $connect->query("DELETE FROM ".$TABLES['messages']." where id = '".mysql_real_escape_string($id)."'") or die(MYSQL_ERROR);
										
		if($delete) {
			echo '<div align="center"><div id="success">
				Successfully deleted message!
			</div></div><br />';
		}
	}
	else {
		header('Location: index.php');
	}
?>