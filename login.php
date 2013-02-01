<?php
	session_start (); 
	include('connection/connector.php');
	include('config.php');
	$connect = new DbConnector();

	$username = $_POST['uname'];
	$password = $_POST['password'];
	$goback=$_POST['goback']?$_POST['goback']:'index.php';

	if(strlen($username) > 0 && strlen($password) > 0) 
	{
		$oRegister = new register;
		$oRegister->username = $username;
		$oRegister->password = $password;
		
		if(!$oRegister->checkUsername()) 
		{
			header('Location: '.$goback.'?error=2');
		}
		else 
		{
			$query = $connect->query("SELECT * FROM ".$TABLES['users']." WHERE username = '".mysql_real_escape_string($username)."'");
				
			if($row = $connect->fetchObject($query)) 
			{
				$password_registered = $row->password;

				if($oRegister->hashPassword() === $password_registered)
				{
					if($row->rank == 'student')
					{
						$select = $connect->query("SELECT studentsid FROM ".$TABLES['uchenici']." WHERE u_key = '".mysql_real_escape_string($row->u_key)."'");
						$row2 = $connect->fetchObject($select);
						
						$oStudents = new students;
						
						if($oStudents->checkConfirm($row2->studentsid))
						{
							$_SESSION["username"] = $username;
							$_SESSION["password"] = $password;
							$_SESSION["user_rank"] = $row->rank;
							$_SESSION["loggedin_student"] = true;
							
							$query = $connect->query("UPDATE ".$TABLES['users']." set online = 'true' where username = '$username' ");
						
							header('Location: menu_functions.php');
						}
						else {
							header('Location: '.$goback.'?error=3');
						}
					}
					else {
						$_SESSION["username"] = $username;
						$_SESSION["password"] = $password;
						$_SESSION["user_rank"] = $row->rank;
						$_SESSION["loggedin"] = true;
				
						$query = $connect->query("UPDATE ".$TABLES['users']." set online = 'true' where username = '$username' ");
						
						header('Location: menu_functions.php');
					}
				}
				else {
						header('Location: '.$goback.'?error=2');
				}
			}
		}
	}
?> 