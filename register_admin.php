<?php
	session_start();
	if($_SESSION['loggedin'] && $_SESSION['user_rank'] == 'director')
	{
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('anketa_header.php');
		
		$connect = new DbConnector();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2009 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
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
								Registration form for administrators
							</font>
							<br />
							<b>
								 All fields are required to be filled!
							</b>
						<hr width="80%" color="#c3c3c3" size="1" />
						<?php
							$connect = new DbConnector();
							
							$ime = addslashes($_POST['ime']);
							
							$familiq = addslashes($_POST['familiq']);
							
							$username = addslashes($_POST['username']);
						
							$password1 = $_POST['password1'];
							
							$password2 = $_POST['password2'];
							
							$email = addslashes($_POST['email']);
							
							$rank = 'admin';
							
							$oRegister = new register;
							$oRegister->username = $username;
							$teacherid = $oRegister->teacherId();
							
							if($_GET['action'] == 2)
							{
								if($oRegister->usernameValidation())
								{
									//echo '<div id="error">Съществуващ потребител!</div>';
								}
								else if(!ctype_alpha($ime) || !ctype_alpha($familiq))
								{
									echo '<div id="error">Incorrectly filled form!</div>';
								}
								else {
									if(strlen($ime) > 1 && strlen($familiq) > 2 && is_string($familiq) && is_string($ime) && strlen($password1) > 3 && $password1 === $password2)
									{
										if(preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
										{
											$oRegister->password = $password1;
											$md5_password = $oRegister->hashPassword();
																			
											$query = $connect->query("INSERT INTO ".$TABLES['users']." (id, username, password, ime, familiq, rank, online, teacherid, email) VALUES(Null, '$username', '$md5_password', '$ime', '$familiq', 'admin', 'false', '$teacherid', '$email')");
																			
											if($query) {
												echo '<div align="center"><div id="success">Successfully registered administrator - '.$username.'!</div></div>';
											}
										}
										else {
											echo '<div align="center"><div id="error">Invalid e-mail!</div></div>';
										}
									}
									else {
										echo '<div align="center"><div id="error">Incorrectly filled forms!</div></div>';
									}
								}
							}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2" method="post" name="register">
							<table width="auto" border="0" align="center">  
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Name:</b> </font>&nbsp;</div>
										<input name="ime" id="ime" size="20" type="text" onblur="checkIme()"/>
										<div id="imeMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Surname:</b></font>&nbsp;</div>
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
										<input type="submit" name="submit" value="Register >" class="yellow_button" />
									</td>
								</tr>
							</table>
						</form>
						<hr width="80%" color="#c3c3c3" size="1" />
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