<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		$connect = new DbConnector();

		main::setEncoding();
		
		$par = addslashes($_GET['paralelka']);
		$class = addslashes($_GET['klas']);
							
		$oCheckParalelka = new paralelki;
		$oCheckParalelka->classes = $class;
		$oCheckParalelka->paralelka = $par;
							
		$select = $connect->query("SELECT classid FROM ".$TABLES['paralelki']." order by classid desc") or die(MYSQL_ERROR);
		$row = $connect->fetchObject($select);
		$max = $row->classid+1;
		
		if($row) $classid = $max;
		else $classid = 1;
			
		if(strlen($par) == 1)
		{	
			if(is_numeric($par))
			{
				echo '<div align="center"><div id="error">The sub-class must contain only letters!</div></div>';
			}
			else {
				if($oCheckParalelka->checkParalelka())
				{
					echo '<div align="center"><div id="error">There is already such "<u>'.$par.'</u>" sub-class in '.$class.' class</div></div>';
				}
				else {
					$query = $connect->query("INSERT INTO ".$TABLES['paralelki']." (klas, class_name, classid) VALUES('$class', '$par', '$classid')") or die(MYSQL_ERROR);
					if($query) {
						echo '<div align="center"><div id="success">Successfully added sub-class!</div></div>';
					}
				}
			}
		}
		else {
			echo '<div align="center"><div id="error">The sub-class should contain only one letter!</div></div>';
		}
	}
	else {
		header('Location: index.php');
	}
?>