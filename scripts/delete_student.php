<?php
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('../connection/connector.php');
		require_once('../config.php');

		main::setEncoding();
		
		$id = htmlspecialchars($_GET['id']);
		
		$connect = new DbConnector();
		
		$select = $connect->query("SELECT u_key FROM ".$TABLES['uchenici']." where studentsid = '".mysql_real_escape_string($id)."'")or die(MYSQL_ERROR);
		$row = $connect->fetchObject($select);
		$u_key = $row->u_key;
		
		$delete = $connect->query("DELETE FROM ".$TABLES['uchenici']." where studentsid = '".mysql_real_escape_string($id)."'") or die(MYSQL_ERROR);
		$delete2 = $connect->query("DELETE FROM ".$TABLES['ocenki']." where studentsid = '".mysql_real_escape_string($id)."'") or die(MYSQL_ERROR);
		$delete3 = $connect->query("DELETE FROM ".$TABLES['zabelejki']." where studentsid = '".mysql_real_escape_string($id)."'") or die(MYSQL_ERROR);
		$delete4 = $connect->query("DELETE FROM ".$TABLES['otsastviq']." where studentsid = '".mysql_real_escape_string($id)."'")or die(MYSQL_ERROR);
		$delete5 = $connect->query("DELETE FROM ".$TABLES['srochni']." where studentsid = '".mysql_real_escape_string($id)."'")or die(MYSQL_ERROR);
		$delete6 = $connect->query("DELETE FROM ".$TABLES['godishni']." where studentsid = '".mysql_real_escape_string($id)."'")or die(MYSQL_ERROR);
		$delete7 = $connect->query("DELETE FROM ".$TABLES['users']." where u_key = '$u_key'")or die(MYSQL_ERROR);
										
		if($delete && $delete2 && $delete3 && $delete4 && $delete5 && $delete6 && $delete7) {
			echo '<div id="success">
					Successfully deleted teacher!
			</div><br />';
		}
	}
	else {
		header('Location: index.php');
	}
?>