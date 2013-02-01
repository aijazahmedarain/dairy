<?php
	session_start();
	if($_SESSION['loggedin'] && $_SESSION['user_rank'] == 'director')
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		main::setEncoding();
		
		$id = htmlspecialchars($_GET['id']);
		
		$connect = new DbConnector();
					
		$select = $connect->query("SELECT * FROM ".$TABLES['users']." where id = '".mysql_real_escape_string($id)."'") or die(MYSQL_ERROR);
		$row = $connect->fetchObject($select);
		
		if($row->rank == 'teacher') {
			$teacherid = $row->teacherid;
			$delete_r = $connect->query("DELETE FROM ".$TABLES['predmet_teacher']." where teacherid = '".mysql_real_escape_string($teacherid)."'") or die(MYSQL_ERROR);
			$delete_r2 = $connect->query("DELETE FROM ".$TABLES['teacher_klas']." where teacherid = '".mysql_real_escape_string($teacherid)."'") or die(MYSQL_ERROR);
			//$delete_r3 = $connect->query("DELETE FROM ".$TABLES['ocenki']." where teacherid = '$teacherid'") or die(MYSQL_ERROR);
		}
					
		$delete = $connect->query("DELETE FROM ".$TABLES['users']." where id = '".mysql_real_escape_string($id)."'") or die(MYSQL_ERROR);
		
		if($delete && $delete_r && $delete_r2 && $row->rank == 'teacher') {
			echo '<div id="success">
					Successfully deleted teacher!
				</div><br />';
		}
		if($delete && $row->rank == 'admin')
		{
			echo '<div id="success">
					Successfully deleted administrator!
				</div><br />';
		}
	}
	else {
		header('Location: index.php');
	}
?>