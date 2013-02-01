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
		
		$oSrok = new srok;
		$srok = $oSrok->get_srok();
		
		$studentsid = addslashes($_GET['studentsid']);
		$predmetid = addslashes($_GET['predmetid']);
		$classid = addslashes($_GET['classid']);
		$zabelejka = addslashes($_GET['zabelejka']);
		$date = date("d/m/Y"); 

		if(is_numeric($studentsid) && is_numeric($predmetid) && is_numeric($classid))
		{
			$oKlas = new klas;
			$oKlas->teacherid = $teacherid;
			$oKlas->classid = $classid;
			$oKlas->studentsid = $studentsid;
			$oKlas->predmetid = $predmetid;
		
			if($oKlas->writeTeacherAccess())
			{
				if($srok != '0')
				{
					if(strlen($zabelejka) > 0)
					{
						$oStudents = new students;
						
						if($oStudents->checkConfirm($studentsid))
						{
							$query = $connect->query("INSERT INTO ".$TABLES['zabelejki']." (teacherid, studentsid, predmetid, classid, zabelejka, srok, date) VALUES('$teacherid', '$studentsid', '$predmetid', '$classid', '$zabelejka', '$srok', '$date')") or die(MYSQL_ERROR);
							if($query)
							{
								echo '<b><font color="green">Successfully added notice!!!</font></b>';
							}
						}
						else {
							echo '<font color="red">Unconfirmed student!</font>';
						}
					}
					else {
						echo '<b><font color="red">Please fill the form!!!</font><b>';
					}
				}
				else {
					echo '<font color="red">Error!</font>';
				}
			}
			else {
				echo '<font color="red">Invalid information!</font>';
			}
		}
		else {
			echo '<b><font color="red">Invalid information!</font><b>';
		}
	}
	else {
		header('Location: index.php');
	}
?>