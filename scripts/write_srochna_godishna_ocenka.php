<?php
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		require_once('../functions.php');
		
		main::setEncoding();
		
		$connect = new DbConnector();
		
		$oMain = new main;
		$teacherid = $oMain->get_teacherid($_SESSION['username']);
		
		$oSrok = new srok;
		$srok = $oSrok->get_srok();
		
		$predmetid = addslashes($_GET['predmetid']);
		$classid = addslashes($_GET['classid']);
		$studentsid = addslashes($_GET['studentsid']);
		$tip = addslashes($_GET['tip']);
		$ocenka = addslashes($_GET['ocenka']);
		
		if(is_numeric($predmetid) && is_numeric($classid) && is_numeric($studentsid))
		{
			if($tip == '1' || $tip == '2' || $tip == '3')
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
							if($tip == '1' || $tip == '2')
							{
								$query = $connect->query("INSERT INTO ".$TABLES['srochni']." (predmetid, classid, teacherid, studentsid, srok, ocenka) VALUES('$predmetid', '$classid', '$teacherid', '$studentsid', '$tip', '$ocenka')")or die(MYSQL_ERROR);
								
								if($query)
								{
									echo '<b><font color="'.ocenkaColor($ocenka).'">'.ocenkaWord($ocenka).' - '.$ocenka.'</font></b>';
								}
							}
							if($tip == '3')
							{
								$query = $connect->query("INSERT INTO ".$TABLES['godishni']." (predmetid, classid, teacherid, studentsid, ocenka) VALUES('$predmetid', '$classid', '$teacherid', '$studentsid', '$ocenka')")or die(MYSQL_ERROR);
								
								if($query)
								{
									echo '<b><font color="'.ocenkaColor($ocenka).'">'.ocenkaWord($ocenka).' - '.$ocenka.'</font></b>';
								}
							}
						}
						else {
							echo '<font color="red">Invalid information!</font>';
						}
					}
					else {
						echo '<font color="red">Error!</font>';
					}
				}
				else {
					echo '<b><font color="red">Invalid information!</font><b>';
				}
			}
			else {
				echo '<b><font color="red">Invalid information!</font><b>';
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