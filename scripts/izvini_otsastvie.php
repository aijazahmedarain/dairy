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
		$classid = addslashes($_GET['classid']);
		
		if(is_numeric($classid) && is_numeric($classid))
		{
			$oKlas = new klas;
			
			if($oKlas->checkKlasen($teacherid, $classid))
			{
				$select = $connect->query("SELECT otsastvie FROM ".$TABLES['otsastviq']." WHERE id = '".mysql_real_escape_string($id)."'")or die(MYSQL_ERROR);
				$row = $connect->fetchObject($select);
				
				if($row->otsastvie == 1.0)
				{
					$query = $connect->query("UPDATE ".$TABLES['otsastviq']." SET izvineno = 'true' WHERE id = '".mysql_real_escape_string($id)."'")or die(MYSQL_ERROR);
					
					if($query)
					{
						echo '<font color="green">Excused!</font>';
					}
				}
				else {
					echo '<font color="red">Inexcused!</font>';
				}
			}
		}
	}
	else {
		header('Location: index.php');
	}
?>