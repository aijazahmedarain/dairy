<?php
	session_start();
	if($_SESSION['loggedin'])
	{
		include('../connection/connector.php');
		include('../config.php');
	
		main::setEncoding();
		
		$connect = new DbConnector();
		
		$oMain = new main;
		$teacherid = $oMain->get_teacherid($_SESSION['username']);

		$oSrok = new srok;
		$srok = $oSrok->get_srok();

		$classid = addslashes($_GET['classid']);
		$studentsid = addslashes($_GET['studentsid']);
		$predmetid = addslashes($_GET['predmetid']);
		$otsastvie = addslashes($_GET['otsastvie']);
		$date = date("d/m/Y"); 
		$izvineno = 'false';
		
		if(is_numeric($studentsid) && is_numeric($predmetid) && is_numeric($classid))
		{
			$oKlas = new klas;
			$oKlas->teacherid = $teacherid;
			$oKlas->predmetid = $predmetid;
			$oKlas->studentsid = $studentsid;
			$oKlas->classid = $classid;
			
			if($oKlas->writeTeacherAccess())
			{
				if($srok != 0)
				{
					if($otsastvie == 'treta' || $otsastvie == 'cqlo')
					{	
						$oOtsastviq = new otsastviq;
						$real_otsastvie = $oOtsastviq->returnOtsastvie($otsastvie, 'real');
						
						$oStudents = new students;
						
						if($oStudents->checkConfirm($studentsid))
						{
							$query = $connect->query("INSERT INTO ".$TABLES['otsastviq']." (teacherid, studentsid, classid, predmetid, otsastvie, izvineno, date, srok) VALUES('$teacherid', '$studentsid', '$classid', '$predmetid', '$real_otsastvie', '$izvineno', '$date', '$srok')") or die(MYSQL_ERROR);
								
							if($query)
							{
								echo '<b><font color="red">'.$oOtsastviq->returnOtsastvie($otsastvie, 'unreal').' - absence</font></b>';
							}
						}
						else {
							echo '<font color="red">Unconfirmed student!</font>';
						}
					}
					else {
						echo '<font color="red">Error!</font>';
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
		header('Location :index.php');
	}
?>