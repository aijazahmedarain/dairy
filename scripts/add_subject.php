<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		// require Connection, Functions and Variables
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		$connect = new DbConnector();
		
		main::setEncoding();
		
		$predmet = addslashes($_GET['predmet']);
		
		$oPredmet = new predmet;
		$oPredmet->predmet = $predmet;
		
		$predmetid = $oPredmet->predmetId();
		
		if($oPredmet->checkPredmet())
		{
			echo '<div align="center"><div id="error">This subject alredy exists!</div></div>';
		}
		else {
			if(strlen($predmet) >  2 && preg_match("/^[A-Za-z0-9]+$/", $predmet))
			{
				$query = $connect->query("INSERT INTO ".$TABLES['predmeti']." (predmetid, predmet) VALUES('$predmetid', '$predmet')") or die(MYSQL_ERROR);
				if($query) {
					echo '<div align="center"><div id="success">Successfully added subject - '.$predmet.'!</div></div>';
				}
			}
			else {
				echo '<div align="center"><div id="error">Invalid name for subject!</div></div>';
			}
		}
	}
	else {
		header('Location: index.php');
	}
?>