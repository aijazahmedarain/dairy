<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		$connect = new DbConnector();

		$class = htmlspecialchars($_GET['class']);
		
		$select = $connect->query("SELECT * FROM ".$TABLES['paralelki']." where klas = '".mysql_real_escape_string($class)."'") or die(MYSQL_ERROR);

		if($connect->numRows($select))
		{
			while($row = $connect->fetchObject($select))
			{
				echo $classid = $row->classid;
				
				$delete3 = $connect->query("DELETE FROM ".$TABLES['uchenici']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);	
				$delete4 = $connect->query("DELETE FROM ".$TABLES['teacher_klas']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
				$delete5 = $connect->query("DELETE FROM ".$TABLES['predmet_klas']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
				$delete6 = $connect->query("DELETE FROM ".$TABLES['ocenki']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
				$delete7 = $connect->query("DELETE FROM ".$TABLES['otsastviq']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
				$delete8 = $connect->query("DELETE FROM ".$TABLES['godishni']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
				$delete9 = $connect->query("DELETE FROM ".$TABLES['srochni']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
				$delete10 = $connect->query("DELETE FROM ".$TABLES['users']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
			}
		}
		
		$delete = $connect->query("DELETE FROM ".$TABLES['klasove']." where class = '".mysql_real_escape_string($class)."'") or die(MYSQL_ERROR);
		$delete2 = $connect->query("DELETE FROM ".$TABLES['paralelki']." where klas = '".mysql_real_escape_string($class)."'") or die(MYSQL_ERROR);
	}
	else {
		header('Location: index.php');
	}
?>