<?php	
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'teacher'))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		main::setEncoding();
		$connect = new DbConnector();
		if(isset($_GET['header_informaciq']))
		{
			$header_informaciq = addslashes($_GET['header_informaciq']);
			$query = $connect->query("SELECT * FROM ".$TABLES['informaciq']." WHERE place = 'school_title'");
			if(!$connect->numRows($query))
			{
				$query = $connect->query("INSERT INTO ".$TABLES['informaciq']." (informaciq, place) value('".$header_informaciq."', 'school_title')");
				if(!$query)
				{
					echo 'Error!';
				}
			}
			else
			{
				$query = $connect->query("UPDATE ".$TABLES['informaciq']." SET informaciq = '".$header_informaciq."' WHERE place = 'school_title' ");
				if(!$query)
				{
					echo 'Error!';
				}
			}
		}
	}
?>