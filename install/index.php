<?php 
	require_once('../connection/connector.php');
	require_once('../functions.php');
	require_once('../config.php');
	$connect = new DbConnector();
	$lines = file("./connection.txt");
	$query = "SELECT * FROM ".$TABLES['users']." WHERE rank = 'director'";
	$query = $connect->query($query);
	$rows = $connect->fetchObject($query);
	if(!$lines)
	{
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2009 School diary All rights reserved. Designed and developed by Azuneca -->
	<head>
	<title>
		School diary
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" /> 
	<meta name='Description' content="school diary" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../js/main.js"></script>
	<script type="text/javascript" src="../js/boxover.js"></script>
	<script type="text/javascript" src="../js/scripts.js"></script>
	<link rel="stylesheet" href="../styles/general_design.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../styles/menu.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../styles/footer.css" type="text/css" media="screen" />
	<link rel="icon" href="../images/icon.png" type="image/x-icon"/>
	</head>
	<body>
		<div align="center">
			<div align="center" class="inner_div"> 
				<form method="POST" action="" >
					<table align="center" width="500" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="2" align="center" style="font-size:18px;">
								Installation of the application:
							</td>
						</tr>
						<tr>
							<td height="40" >
							</td>
						</tr>
						<tr>
							<td align="right" width="40%" >
								Host of the database
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="text" class="register_field"  id="dbhost" name="dbhost" />
							</td>
						</tr>
						<tr>
							<td height="30" >
							</td>
						</tr>
						<tr>
							<td align="right" width="40%" >
								Username of the database:
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="text" class="register_field"  id="dbusername" name="dbusername" />
							</td>
						</tr>
						<tr>
							<td height="30" >
							</td>
						</tr>
						<tr>
							<td align="right" width="40%" >
								Password of the database:
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="password" class="register_field" id="dbpassword" name="dbpassword" />
							</td>
						</tr>
						<tr>
							<td height="30" >
							</td>
						</tr>
						<tr>
							<td align="right" width="40%" >
								Name of the database:
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="text" class="register_field" id="dbname" name="dbname" />
							</td>
						</tr>
						<tr>
							<td height="30" >
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center" >
								<input type="submit" class="button1" name="db_submit" value="Continue>>" />
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2">
								<br /><b>Note: if you want to reinstall the application drop the database from the phpmyadmin
								and then load the reinstall.php file which is located in the install folder!</b>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
	</html>
	<?php
		if(isset($_POST['db_submit']) && isset($_POST['dbhost']) && isset($_POST['dbusername']) && isset($_POST['dbpassword']) && isset($_POST['dbname']))
		{
			$dbhost = $_POST['dbhost'];
			$dbusername = $_POST['dbusername'];
			$dbpassword = $_POST['dbpassword'];
			$dbname = $_POST['dbname'];
			if(strlen($dbhost) > 0 && strlen($dbusername) > 0 && strlen($dbname) > 0)
			{
				$file = fopen('../connection.txt', 'w+');
				$data = $dbhost.'|'.$dbusername.'|'.$dbpassword.'|'.$dbname;
				fwrite($file, $data);
				fclose($file);
				copy('../connection.txt', '../scripts/connection.txt');
				copy('../connection.txt', './connection.txt');
				$con = mysql_connect($dbhost,$dbusername,$dbpassword);
				// Create database
				if (mysql_query("CREATE DATABASE $dbname collate cp1251_general_ci",$con))
				header("Location: index.php");
				echo '<meta http-equiv="refresh" content="1;url=index.php" >
';
			}
			else
			{
				?>
				<script>
					alert('Please fill the fields!');
				</script>
				<?php
			}
		}
	}
	elseif($lines && !$connect->query("SELECT * FROM users"))
	{
				$error='There has been an error with the database!';				
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['users']." 
				(
						id INT(8) NOT NULL auto_increment Primary key,
						teacherid INT(8) NOT NULL,
						username varchar(15) NOT NULL default'',
						password varchar(40) NOT NULL default'',
						email varchar(40) NOT NULL default'',
						ime varchar(15) NOT NULL default'',
						prezime varchar(15) NOT NULL default'',
						familiq varchar(15) NOT NULL default'',
						znpz INT(8) NOT NULL,
						rank varchar(10) NOT NULL default'',
						online varchar(5) NOT NULL default'',
						u_key varchar(5) NOT NULL default'',
						classid INT(8) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table '".$TABLES['users']."' was successfully created.<br />";
				}
				else
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// анкета въпрос
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['anketa']."
				(
					question varchar(255) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['anketa']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// анкета отговори
				$query = "CREATE TABLE IF NOT EXISTS `".$TABLES['anketa_q']."` 
				(
					`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`option` VARCHAR( 255 ) NOT NULL ,
					`votes` INT( 11 ) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['anketa_q']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// съобщения
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['messages']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					name VARCHAR (255) NOT NULL default '',
					news TEXT (2000) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['messages']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// класове
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['klasove']."
				(
					id INT(8) NOT NULL auto_increment Primary key,
					class VARCHAR(4) NOT NULL default ''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['klasove']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// паралелки
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['paralelki']."
				(
					id INT(8) NOT NULL auto_increment Primary key,
					classid INT(8) NOT NULL,
					klas INT(2) NOT NULL,
					class_name VARCHAR(2) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['paralelki']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// ученици
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['uchenici']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					classid INT(8) NOT NULL,
					studentsid INT(8) NOT NULL,
					ime VARCHAR(20) NOT NULL default'',
					prezime VARCHAR(20) NOT NULL default'',
					familiq VARCHAR(20) NOT NULL default'',
					number INT(2) NOT NULL,
					egn VARCHAR(10) NOT NULL default'',
					telefon VARCHAR(15) NOT NULL default'',
					mestojiveene VARCHAR(90) NOT NULL default'',
					u_key VARCHAR(5) NOT NULL default'', 
					checked VARCHAR(5) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['uchenici']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// програма
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['programa']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					den VARCHAR(20) NOT NULL,
					chas VARCHAR(20) NOT NULL,
					vreme VARCHAR(30) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['programa']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// програма с предмеTи
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['programa_predmeti']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					day VARCHAR(20) NOT NULL,
					chas int(11) NOT NULL,
					predmet VARCHAR(30) NOT NULL,
					teacherid VARCHAR(30) NOT NULL,
					classid INT(11) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['programa']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// предмеTи
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['predmeti']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					predmetid INT(8) NOT NULL,
					predmet VARCHAR(55) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['predmeti']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// предмеT -> учиTел
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['predmet_teacher']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					predmetid INT(8) NOT NULL,
					teacherid INT(8) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['predmet_teacher']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// учиTел -> клас
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['teacher_klas']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					classid INT(8) NOT NULL,
					teacherid INT(8) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['teacher_klas']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// предмеT -> клас
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['predmet_klas']." 
				(
					id INT(8) NOT NULL auto_increment Primary key,
					predmetid INT(8) NOT NULL,
					classid INT(8) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['predmet_klas']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// оценки
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['ocenki']."
				(
					`id` INT(11) NOT NULL auto_increment PRIMARY KEY,
					studentsid INT(8) NOT NULL,
					teacherid INT(8) NOT NULL,
					predmetid INT(8) NOT NULL,
					classid INT(8) NOT NULL,
					ocenka INT(1) NOT NULL,
					srok INT(1) NOT NULL,
					date VARCHAR(10) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['ocenki']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// учебни срокове
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['srok']."
				(
					id INT(8) NOT NULL auto_increment PRIMARY KEY,
					srok INT(1) NOT NULL,
					date_from VARCHAR(15) NOT NULL default'',
					date_to VARCHAR(15) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['srok']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// забележки
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['zabelejki']."
				(
					`id` INT(11) NOT NULL auto_increment PRIMARY KEY,
					studentsid INT(8) NOT NULL,
					teacherid INT(8) NOT NULL,
					predmetid INT(8) NOT NULL,
					classid INT(8) NOT NULL,
					zabelejka VARCHAR(250) NOT NULL default'',
					srok INT(1) NOT NULL,
					date VARCHAR(10) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['zabelejki']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// оTсъсTвия
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['otsastviq']."
				(
					`id` INT(11) NOT NULL auto_increment PRIMARY KEY,
					studentsid INT(8) NOT NULL,
					teacherid INT(8) NOT NULL,
					predmetid INT(8) NOT NULL,
					classid INT(8) NOT NULL,
					otsastvie FLOAT(2,1) NOT NULL,
					izvineno VARCHAR(5) NOT NULL default'',
					srok INT(1) NOT NULL,
					date VARCHAR(10) NOT NULL default''
				)";
				if($connect->query($query))
				{
					echo "The table ".$TABLES['otsastviq']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// класен
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['klasen']."
				(
					`id` INT(11) NOT NULL auto_increment PRIMARY KEY,
					classid INT(8) NOT NULL,
					teacherid INT(8) NOT NULL
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['klasen']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// срочни оценки
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['srochni']."
				(
					 `id` INT(11) NOT NULL auto_increment PRIMARY KEY,
					 studentsid INT(8) NOT NULL,
					 teacherid INT(8) NOT NULL,
					 predmetid INT(8) NOT NULL,
					 classid INT(8) NOT NULL,
					 ocenka INT(1) NOT NULL,
					 srok INT(1) NOT NULL
				)";
				if($connect->query($query))
				{
					echo "The table ".$TABLES['srochni']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// годишни оценки
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['godishni']."
				(
					 `id` INT(11) NOT NULL auto_increment PRIMARY KEY,
					 studentsid INT(8) NOT NULL,
					 teacherid INT(8) NOT NULL,
					 predmetid INT(8) NOT NULL,
					 classid INT(8) NOT NULL,
					 ocenka INT(1) NOT NULL
				)";
				if($connect->query($query))
				{
					echo "The table ".$TABLES['godishni']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// информация
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['informaciq']."
				(
					 `id` INT(11) NOT NULL auto_increment PRIMARY KEY,
					 place VARCHAR(50) NOT NULL default'',
					 informaciq TEXT  NOT NULL default''
				)";
				if($connect->query($query))
				{
					echo "The table ".$TABLES['informaciq']." was successfully created.<br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				// Tаблица съобщения учиTел
				$query = "CREATE TABLE IF NOT EXISTS ".$TABLES['teacher_messages']."
				(
					id INT(8) NOT NULL auto_increment Primary key,
					teacherid INT(8) NOT NULL,
					ime VARCHAR(30) NOT NULL default'',
					email VARCHAR(40) NOT NULL default'',
					egn VARCHAR(10) NOT NULL default'',
					message VARCHAR(250) NOT NULL default'',
					checked VARCHAR(5) NOT NULL default'',
					date VARCHAR(10) NOT NULL default''
				)";
				if($connect->query($query)) 
				{
					echo "The table ".$TABLES['teacher_messages']." was successfully created.<br /><br />";
				}
				else 
				{
					echo "<script>alert('".$error."')</script>";
					die();
				}
				
				echo '<a href="index.php">Continue >></a>';
	}
	elseif(!$rows)
	{
		if(isset($_POST['register_admin']) && isset($_POST['name']) && isset($_POST['username']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['email']))
		{
			unlink( './connection.txt');
			$username = htmlspecialchars($_POST['username']);
			$name = htmlspecialchars($_POST['name']);
			$last_name = htmlspecialchars($_POST['last_name']);
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			$email = $_POST['email'];
			$confirm = "true";
			if(strlen($username) > 4)
			{
				if(strlen($name) > 0)
				{
					if(strlen($last_name) > 0)
					{
						if($password == $password2 && strlen($password) > 5)
						{
							if(preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
							{
								$cRegister = new register;
								$cRegister->password = $password;
								$password = $cRegister->hashPassword();								
								$query = $connect->query("INSERT INTO users (teacherid, username, password, ime,  familiq, znpz, rank, email)VALUES('1', '".$username."', '".$password."', '".$name."', '".$last_name."', '1000', 'director', '".$email."')");
								if($query)
								{	
									// deleting the connection file
									unlink('connection.txt');
									
									?>
									<script>
										alert('Successful registration!');
										window.location = '../index.php';
									</script>
									<?php	
								}
								else
								{										
									?>
									<script>
										alert('Error!');
										
									</script>
									<?php										
								}
							}
							else
							{
							?>
							<script>
								alert('Invalid e-mail!');
							</script>
						<?php
							}
						}
						else
						{
						?>
						<script>
							alert('The passwords does not match!');
						</script>
						<?php
						}
					}
					else
					{
					?>
					<script>
						alert('Fill last name!');
					</script>
					<?php
					}
				}
				else
				{
					?>
					<script>
						alert('Fill first name!');
					</script>
					<?php
				}
			}
			else
			{
				?>
				<script>
					alert('Fill username!');
				</script>
				<?php
			}
		}
	
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2009 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
	<head>
	<title>
		School diary - Installation
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" /> 
	<meta name='Description' content="електронен дневник, иван илиев, е-дневник, училищен дневник, дневник, оценки, учители, ученици" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../js/main.js"></script>
	<script type="text/javascript" src="../js/boxover.js"></script>
	<script type="text/javascript" src="../js/scripts.js"></script>
	<link rel="stylesheet" href="../styles/general_design.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../styles/menu.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../styles/footer.css" type="text/css" media="screen" />
	<link rel="icon" href="../images/icon.png" type="image/x-icon"/>
	</head>
	<body>
		<div align="center">
			<div align="center" class="inner_div"> 
				<form method="POST" action="" >
					<table align="center" width="500" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="2" align="center" style="font-size:18px;">
								Headmaster registration
							</td>
						</tr>
						<tr>
							<td height="40" >
							</td>
						</tr>
						<tr valign="top">
							<td align="right" width="40%">
								<label for="name">Username:</label>
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="text" class="register_field" name="username"  id="username" onblur="validate_name('username', 'Enter username');"/>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td height="30" valign="top" id="message_username" >
								
							</td>
						</tr>
						<tr valign="top">
							<td align="right" width="40%">
								<label for="name">Name:</label>
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="text" class="register_field" name="name"  id="name" onblur="validate_name('name', 'Fill name');"/>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td height="30" valign="top" id="message_name" >
								
							</td>
						</tr>
						<tr valign="top">
							<td align="right" width="40%">
								<label for="last_name">Surname:</label>
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="text" class="register_field" name="last_name"  id="last_name" onblur="validate_name('last_name', 'Fill surname');"/>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td height="30" valign="top" id="message_last_name" >
								
							</td>
						</tr>
						<tr>
							<td align="right" width="40%" >
								<label for="password">Password:</label>
							</td>
							<td align="left" width="60%" >
								&nbsp;&nbsp;<input type="password" name="password" id="password" class="register_field"  onkeyup="pass_str();" onblur="validate_password1();"  />&nbsp;&nbsp;<div style="font-size:12px;color:red; display:inline;" id="pass_str"></div>
							</td>
						</tr>
						<tr valign="top" > 
							<td>		
							</td>
							<td height="20" align="left">
								&nbsp;&nbsp;<font style="font-size:12px;">Minimal length 6 symbols!</font>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td height="20" valign="top" id="message_pass" >
								
							</td>
						</tr>
						<tr>
							<td align="right" >
								<label for="password2">Confirm password:</label>
							</td>
							<td align="left" >								
								&nbsp;&nbsp;<input type="password" name="password2" id="password2" class="register_field" onblur="validate_password2();"  />
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td height="30" valign="top" id="message_pass2" >
								
							</td>
						</tr>
						<tr>
							<td align="right" width="40%" >
								<label for="email">E-mail:</label>
							</td>
							<td align="left" width="60%">								
								&nbsp;&nbsp;<input type="text" name="email" id="email" class="register_field"  onblur="validate_email();" />
							</td>
						</tr>
						<tr valign="top" >
							<td>
							</td>
							<td  height="20" valign="top" align="left" >
								&nbsp;&nbsp;<font style="font-size:12px;">Example: myname@example.com</font>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td height="30" valign="top" id="message_email" >
								
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" name="register_admin" value="Register!" class="button1" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
	</html>
	
	<?php
	}
	elseif($rows)
	{
		header('Location: ../index.php');
	}
	?>
</body>
</html>