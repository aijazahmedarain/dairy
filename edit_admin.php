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
<!-- Copyright 2013 School diary All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script type="text/javascript" src="js/register_check.js"></script>
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
								<img src="images/profile_edit.png" alt="" /> 
								<?php
									$username2 = htmlspecialchars($_GET['username']);
									$oMain = new main;
									echo 'Profile : <font color="green"><u>'.$oMain->callName($username2).'</u></font>';
								?>
							</font>
							<br />
						<hr width="80%" color="#c3c3c3" size="1" />	
						<?php
							// ���������� ������������	
							$password = $_POST['password1'];
							
							$ime = addslashes($_POST['ime']);
							
							$familiq = addslashes($_POST['familiq']);
							
							$email = addslashes($_POST['email']);

							$action = $_GET['action'];
							
							$oRegister = new register;
							$oRegister->password = $password;
							$md5_password = $oRegister->hashPassword();

							$select = $connect->query("SELECT * FROM ".$TABLES['users']." where username='".mysql_real_escape_string($username2)."'") or die(MYSQL_ERROR);
							if($connect->numRows($select))
							{
								while($row = $connect->fetchObject($select))
								{
									if($action == 2)
									{
										if(!ctype_alpha($ime) || !ctype_alpha($familiq))
										{
											
										}
										else {
											if(is_string($ime) && strlen($ime) > 3 && $ime != $row->ime)
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET ime = '".$ime."' where username = '$username2'") or die(MYSQL_ERROR);
												echo '<meta http-equiv="refresh" content="0;url=edit_admin.php?username='.$username2.'" />';
											}
											if(is_string($familiq) && strlen($familiq) > 3 && $familiq != $row->familiq)
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET familiq = '".$familiq."' where username = '$username2'") or die(MYSQL_ERROR);
												echo '<meta http-equiv="refresh" content="0;url=edit_admin.php?username='.$username2.'" />';
											}
											if($email != $row->email && preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET email = '".$email."' where username = '$username2'")or die(MYSQL_ERROR);
												echo '<meta http-equiv="refresh" content="0;url=edit_admin.php?username='.$username2.'" />';
											}
											if(strlen($password) > 3 && $md5_password != $row->password )
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET password = '".$md5_password."' where username = '$username2'") or die(MYSQL_ERROR);
												if($query) {
													echo '<div align="center"><div id="success">Successfully changed password!</div></div>';
													//echo '<meta http-equiv="refresh" content="2;url=edit_admin.php?username='.$username2.'" />';
												}
											}
										}
									}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2&username=<?php echo $username2; ?>" method="post" name="register">
							<table width="auto" border="0" align="center">  
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>First name:</b></font>&nbsp;</div>
										<input name="ime" id="ime" size="20" type="text" onblur="checkIme()" value="<?php echo $row->ime; ?>" />
										<div id="imeMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Surname:</b></font>&nbsp;</div>
										<input name="familiq" id="familiq" size="20" type="text" onblur="checkFamiliq()" value="<?php echo $row->familiq; ?>" />
										<div id="familiqMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>E-mail:</b></font>&nbsp;</div>
										<input name="email" id="email" size="20" type="text" onblur="checkEmail()" value="<?php echo $row->email; ?>" />
										<div id="emailMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>New password:</b></font>&nbsp;</div>
										<input name="password1" id="password1" size="20" type="password" onblur="checkPassword()"/>
										<div id="passwordMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td align="center">
										<input type="submit" name="submit" value="Edit >" class="yellow_button" />
									</td>
								</tr> 
							</table>
							<hr width="80%" color="#c3c3c3" size="1" />
						</form>
						<?php
								}
							}
							echo '<br />';
						?>
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
