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
		$ocenka = addslashes($_GET['ocenka']);
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
					if(is_numeric($ocenka) && $ocenka > 1 && $ocenka < 7)
					{
						$oStudents = new students;
						
						if($oStudents->checkConfirm($studentsid))
						{
							$query = $connect->query("INSERT INTO ".$TABLES['ocenki']." (teacherid, studentsid, predmetid, classid, ocenka, srok, date) VALUES('$teacherid', '$studentsid', '$predmetid', '$classid', '$ocenka', '$srok', '$date')") or die(MYSQL_ERROR);
							if($query)
							{
								echo '<b><font color="'.ocenkaColor($ocenka).'">'.ocenkaWord($ocenka).' - '.$ocenka.'</font></b>';
							}
						}
						else {
							echo '<font color="red">Непотвърден ученик!</font>';
						}
					}
					else {
						echo '<font color="red">Невалидни данни!</font>';
					}
				}
				else {
					echo '<font color="red">Грешка!</font>';
				}
			}
			else {
				echo '<font color="red">Невалидни данни!</font>';
			}
		}
		else {
			echo '<b><font color="red">Невалидни данни!</font><b>';
		} 
	}
	else {
		header('Location: index.php');
	}
?>