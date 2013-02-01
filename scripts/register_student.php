<?php
	session_start();
	error_reporting(0); 
	if($_SESSION['loggedin'] == false || ($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin' || $_SESSION['user_rank'] == 'teacher')))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		main::setEncoding();
		
		$connect = new DbConnector();
		
		$username = addslashes($_GET['username']);
		
		$password1 = addslashes($_GET['password1']);
		
		$password2 = addslashes($_GET['password2']);
		
		$email = $_GET['email'];
		
		$ime = addslashes($_GET['ime']);
		
		$prezime = addslashes($_GET['prezime']);
							
		$familiq = addslashes($_GET['familiq']);
							
		$mestojiveene = $_GET['mestojiveene'];
							
		$egn = addslashes($_GET['egn']);
							
		$telefon = addslashes($_GET['telefon']);
							
		$classid = addslashes($_GET['classid']);
							
		$number = addslashes($_GET['number']);

		$oStudents = new students;
		$oStudents->classid = $classid;
		$oStudents->number = $number;
		$oStudents->egn = $egn;
		
		$studentsid = $oStudents->studentsId();
		
		$oRegister = new register;
		$oRegister->username = $username;
							
		$kod = $oStudents->generateCode();
						
		if($oStudents->checkEGN())
		{
			echo '<div align="center"><div id="error">Already existing UCC in this class!</div></div>';
		}
		else 
		{
			if(!$oRegister->usernameValidation())
			{
				if(preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
				{
					if($oStudents->checkNumber())
					{
						echo '<div align="center"><div id="error">Already registered number in this class!</div></div>';
					}
					else if(!ctype_alpha($ime) || !ctype_alpha($familiq) || !ctype_alpha($prezime) || is_numeric($mestojiveene))
					{
						echo '<div align="center"><div id="error">Incorrectly field forms!</div></div>';
					}
					else 
					{
						if(is_string($ime) && is_string($familiq) && is_string($prezime) && strlen($ime) > 1 && strlen($familiq) > 2 && strlen($prezime) > 2 && is_numeric($egn) && is_numeric($telefon) && strlen($telefon) > 3 && strlen($egn) == 10 && isset($classid) && $classid != "----------" && is_numeric($classid) && is_numeric($number) && strlen($number) < 3 && strlen($number) > 0 && $password1 === $password2 && strlen($password1) > 3)
						{	
							if($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin' || $_SESSION['user_rank'] == 'teacher')
							{
								$checked = 'true';
							}
							else
							{
								$checked = 'false';
							}
							
							$query = $connect->query("INSERT INTO ".$TABLES['uchenici']." (classid, studentsid, ime, prezime, familiq, egn, telefon, mestojiveene, u_key, number, checked) VALUES('$classid', '$studentsid', '$ime', '$prezime', '$familiq', '$egn', '$telefon', '$mestojiveene', '$kod', '$number', '$checked')");
							
							$oRegister->password = $password1;
							$md5_password = $oRegister->hashPassword();
							
							$query2 = $connect->query("INSERT INTO ".$TABLES['users']." (username, password, email, ime, prezime, familiq, rank, u_key, online, classid) VALUES('$username', '$md5_password', '$email', '$ime', '$prezime', '$familiq', 'student', '$kod', 'false', '$classid')")or die(MYSQL_ERROR);	
							
							if($query && $query2) 
							{
								echo '<div align="center"><div id="success">Succcessfully registered student!</div></div>';
							}
						}
						else 
						{
							echo '<div align="center"><div id="error">Incorrectly field forms!</div></div>';
						}
					}
				}
				else {
					echo '<div align="center"><div id="error">Invalid e-mail!</div></div>';
				}
			}
			else {
			
			}
		}
	}
?>