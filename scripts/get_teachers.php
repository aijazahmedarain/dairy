<?php
	session_start();

	require_once('../connection/connector.php');
	require_once('../config.php');
		
	main::setEncoding();
		
	$connect = new DbConnector();
	
	$egn = $_GET['egn'];
	
	$oStudents = new students;
	$oStudents->egn = $egn;
	
	if(is_numeric($egn) && strlen($egn) == 10)
	{
		if($oStudents->checkEGN())
		{
			echo '<br /><div align="left"><font color="#006F9A" ><b>Teacher : </b></font>&nbsp;</div>
				<select name="teacher" id="teacher">
					<option value="none">------</option>';
					
					$query = $connect->query("SELECT classid FROM ".$TABLES['uchenici']." WHERE egn = '".mysql_real_escape_string($egn)."'")or die(MYSQL_ERROR);
					
					if($connect->numRows($query))
					{
						$request = $connect->fetchObject($query);
						$classid = $request->classid;
						
						$select = $connect->query("SELECT teacherid FROM ".$TABLES['teacher_klas']." WHERE classid = '$classid' && teacherid != 1")or die(MYSQL_ERROR);
							
						if($connect->numRows($select))
						{
							while($row = $connect->fetchObject($select))
							{
								$select_name = $connect->query("SELECT ime, familiq FROM ".$TABLES['users']." WHERE teacherid = '$row->teacherid' && rank = 'teacher'");
								
								$teacher_name = $connect->fetchObject($select_name);
								
								echo '<option value="'.$row->teacherid.'">'.$teacher_name->ime.' '.$teacher_name->familiq.'</option>';
							}
						}
						else 
						{
							echo '<font color="red">There are still no added teachers!</font>';
						}
					}
					
			echo '</select><div><br /></div>';
		}
		else 
		{
			echo '<font color="red">Nonexistent student!</font>';
		}
	}
	else 
	{
		echo '<font color="red">Incorrect UCC!</font>';
	}
?>