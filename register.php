<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('anketa_header.php');
		
		$connect = new DbConnector();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script type="text/javascript" src="js/register_check.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
</head>
<body>
	<div align="center">
		<div id="main">
			<?php
				include('scripts/top_menu.php');
				include('scripts/header.php');
			?>
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
				<tr>
					<td class="left_content" valign="top">
						<hr width="80%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
								<img src="images/icon_rangs.gif" alt="" /> 
								Register form for teachers
							</font>
							<br />
							<b>
								 All fields are required!
							</b>
						<hr width="80%" color="#c3c3c3" size="1" />	
						<?php
							// дефинираме променливите
							$username = addslashes($_POST['username']);
							
							$password1 = $_POST['password1'];
							
							$password2 = $_POST['password2'];
							
							$ime = addslashes($_POST['ime']);
							
							$prezime = addslashes($_POST['prezime']);
							
							$familiq = addslashes($_POST['familiq']);
								
							$znpz = addslashes($_POST['znpz']);
							
							$email = addslashes($_POST['email']);
							
							$predmet = $_POST['predmet'];
							
							$klas = $_POST['klas'];
							
							$rank = 'teacher';

							$online = 'false';
							
							$select2 = $connect->query("SELECT id FROM ".$TABLES['predmeti']."") or die(MYSQL_ERROR);
							$select3 = $connect->query("SELECT id FROM ".$TABLES['paralelki']."") or die(MYSQL_ERROR);
							
							$oRegister = new register;
							$oRegister->username = $username;
							
							$teacherid = $oRegister->teacherId();
							
							$action = $_GET['action'];
							if($action == 2)
							{
								if($oRegister->usernameValidation())
								{
									//echo '<div id="error">Невалиден потребител!</div>';
								}
								else if(!ctype_alpha($ime) || !ctype_alpha($familiq) || !ctype_alpha($prezime))
								{
									echo '<div id="error">Incorrectly field forms!</div>';
								}
								else {
									if($password1 === $password2 && strlen($password1) > 3 && is_string($ime) && is_string($familiq) && is_string($prezime) && strlen($ime) > 1 && strlen($familiq) > 2 && strlen($prezime) > 2 && is_numeric($znpz) && strlen($znpz) > 2 && isset($predmet))
									{
										if(preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
										{

											$oRegister->password = $password1;
											$md5_password = $oRegister->hashPassword();
												
											$query = $connect->query("INSERT INTO ".$TABLES['users']." (teacherid, username, ime, prezime, familiq, password, znpz, rank, online, email) VALUES('$teacherid', '$username', '$ime', '$prezime', '$familiq', '$md5_password','$znpz', '$rank', '$online', '$email')")or die(MYSQL_ERROR);
												
												
											if(isset($predmet) && isset($teacherid))
											{
												$count2 = $connect->numRows($select2);
												for($i = 0; $i<$count2; $i++)
												{
													$predmetid = $predmet[$i];
													if($predmetid != 0)
													{
														$query2 = $connect->query("INSERT INTO ".$TABLES['predmet_teacher']." (teacherid, predmetid) VALUES('$teacherid', '$predmetid')");
													}
												}
											}
											if(isset($klas) && isset($teacherid))
											{
												$count3 = $connect->numRows($select3);
												for($i = 0; $i<$count3; $i++)
												{
													$klasove = $klas[$i];
													if($klasove != 0)
													{
														$query3 = $connect->query("INSERT INTO ".$TABLES['teacher_klas']." (teacherid, classid) VALUES('$teacherid', '$klasove')");
													}
												}
											}
											if($query && $query2 && $query3) 
											{
												echo '<div align="center"><div id="success">Successfully registered teacher - '.$username.'!</div></div>';
											}
											else {
												echo '<div align="center"><div id="error">There has been an error!</div></div>';
											}
										}
										else {
											echo '<div align="center"><div id="error">Invalid e-mail!</div></div>';
										}
									}
									else {
										echo '<div align="center"><div id="error">Incorrectly field forms!</div></div>'; 
									}
								}
							}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2" method="post" name="register">
							<table width="auto" border="0" align="center">  
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>First name:</b> </font>&nbsp;</div>
										<input name="ime" id="ime" size="20" type="text" onblur="checkIme()"/>
										<div id="imeMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Surname:</b></font>&nbsp;</div>
										<input name="prezime" id="prezime" size="20" type="text" onblur="checkPrezime()" />
										<div id="prezimeMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Last name:</b></font>&nbsp;</div>
										<input name="familiq" id="familiq" size="20" type="text" onblur="checkFamiliq()" />
										<div id="familiqMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>E-mail:</b></font>&nbsp;</div>
										<input name="email" id="email" size="20" type="text" onblur="checkEmail()" />
										<div id="emailMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Username:</b></font>&nbsp;</div>
										<input name="username" id="username" size="20" type="text" onblur="check_username()" />
										<div id="status"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Password:</b></font>&nbsp;</div>
										<input name="password1" id="password1" size="20" type="password" onblur="checkPassword()"/>
										<div id="passwordMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Confirm password:</b></font>&nbsp;</div>
										<input name="password2" id="password2" size="20" type="password" onblur="checkPasswords()"/>
										<div id="passwords"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Required hours:</b></font>&nbsp;</div>
										<input name="znpz" id="znpz" size="20" type="text" onblur="checkZnpz()"/>
										<div id="znpzMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Teaches <u>in</u>:</b></font>&nbsp;</div>
										<?php
											echo '<div style="width:540px;">';
												$select = $connect->query("SELECT * FROM ".$TABLES['predmeti']."");
												if($connect->numRows($select)) 
												{
													while($row = $connect->fetchObject($select))
													{
														echo ' <input type="checkbox" name="predmet[]" value="'.$row->predmetid.'" onblur="checkPredmet()" id="predmet" /> '.$row->predmet.' ';
													}
												}
												else {
													echo '<div id="error">There are still no added subjects!</div>';
												}
											echo '</div><div id="predmetMsg"><br /></div>';
										?>
									</td>
								</tr>	
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Teaches <u>on</u>:</b></font>&nbsp;</div>
										<?php
										echo '<div style="width:540px;">';
											$select2 = $connect->query("SELECT * FROM ".$TABLES['paralelki']." order by klas desc") or die(MYSQL_ERROR);
											if($connect->numRows($select2))
											{
												while($row_p = $connect->fetchObject($select2))
												{
													echo ' <input type="checkbox" name="klas[]" id="klas" value="'.$row_p->classid.'" onblur="checkKlasove()" /> ';
													echo $row_p->klas.''.$row_p->class_name;
												}
											}
											else {
												echo '<div id="error">There are still no added classes.</div>';
											}
											echo '</div><div id="klasoveMsg"><br /></div>';
										?>
									</td>
								</tr>
								<tr>
									<td align="center">
										<input type="submit" name="submit" value="Register >" class="yellow_button" />
									</td>
								</tr> 
							</table>
							<hr width="80%" color="#c3c3c3" size="1" />
						</form>
					</td>
					<td class="right_content" valign="top">
						<div align="center">
							<?php
								include('scripts/right_content.php');
							?>
						</div>
					</td>
				</tr>
			</table>
			<?php
				include('scripts/footer.php');
			?>
		</div>
	</div>
</body>
</html>
<?php
	}
	else {
		header('Location: index.php');
	}
?>