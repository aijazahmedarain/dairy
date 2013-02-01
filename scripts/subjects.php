<?php	
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('../connection/connector.php');
		require_once('../functions.php');
		require_once('../config.php');
		
		main::setEncoding();
		
		$connect = new DbConnector();
	
		$select = $connect->query("SELECT * FROM ".$TABLES['predmeti']."") or die(MYSQL_ERROR);
		$count = $connect->numRows($select);
				
		if($count)
		{
			echo '<div align="left" style="margin-left:0px;">';
				while($row = $connect->fetchObject($select))
				{
					echo '<input type="checkbox" name="predmet[]" value="'.$row->predmetid.'" /> '.$row->predmet.'<br />';
				}
			echo '</div>';
		}
		else {
			echo '<div align="center"><div id="error"><font color="black">There are still no added subjects!</font></div></div>';
		}
	}
	else {
		header('Location: index.php');
	}
?>