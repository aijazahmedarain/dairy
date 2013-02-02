<?php
	session_start();
	require_once('connection/connector.php');
	require_once('config.php');
	require_once('anketa_header.php');
	require_once('functions.php');
	$connect = new DbConnector();
	$connect->install();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 School diary All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script language="JavaScript" type="text/javascript" src="js/register_check.js"></script> 
	<script language="JavaScript" type="text/javascript" src="js/ajax.js"></script> 
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
					<td class="left_content" valign="top" align="left">
						<div id="ocenki"></div>
						<div align="center">
							<hr width="80%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
								<img src="images/contacts.png" alt="" /> 
								Contact with a teacher
							</font>
							<br />
							<b>
								 All fields are required to be filled!
							</b>
							<hr width="80%" color="#c3c3c3" size="1" />	
							<?php
							
								$ime = addslashes($_POST['ime']);
								
								$familiq = addslashes($_POST['familiq']);
								
								$email = addslashes($_POST['email']);
								
								$egn = addslashes($_POST['egn']);
								
								$message = addslashes($_POST['message']);
								
								$teacherid = $_POST['teacher'];
									
								if(isset($_POST['submit']))
								{
									$oMain = new main;
									
									if(is_numeric($teacherid) && $oMain->checkTeacherid($teacherid))
									{
										if(preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
										{
											if(!ctype_alpha($ime) || strlen($ime) < 2 || !ctype_alpha($familiq) && strlen($familiq) < 2)
											{
												echo '<div id="error">Invalid name!</div>';
											}
											else 
											{
												if(is_numeric($egn) && strlen($egn) == 10)
												{
													if(strlen($message) > 10)
													{
														$date = date("d/m/Y"); 
														
														$palno_ime = ucfirst($ime).' '.ucfirst($familiq);
														
														$insert = $connect->query("INSERT INTO ".$TABLES['teacher_messages']." (ime, egn, teacherid, message, email, checked, date) VALUES ('$palno_ime', '$egn','$teacherid','$message','$email', 'false', '$date')")or die(MYSQL_ERROR);
														
														if($insert) {
															echo '<div align="center"><div id="success">Successfully sent message!</div></div>';
														}
													}
													else 
													{
														echo '<div id="error">The message should contain more than 10 symbols!</div>';
													}
												}
												else 
												{
													echo '<div id="error">Invalid UCC!</div>';
												}
											}
										}
										else 
										{
											echo '<div id="error">Invalid e-mail!</div>';
										}
									}
									else {
										echo '<div id="error">Invalid teacher!</div>';
									}
								}
							?>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="register">
								<table width="auto" border="0" align="center">  
									<tr>
										<td>
											<div align="left"><font color="#006F9A" ><b>First name:</b> </font>&nbsp;</div>
											<input name="ime" id="ime" size="20" type="text" onblur="checkIme()"/>
											<div id="imeMsg"><br /></div>
										</td>
									</tr>
									<tr>
										<td>
											<div align="left"><font color="#006F9A" ><b>Surname:</b> </font>&nbsp;</div>
											<input name="familiq" id="familiq" size="20" type="text" onblur="checkFamiliq()"/>
											<div id="familiqMsg"><br /></div>
										</td>
									</tr>
									<tr>
										<td>
											<div align="left"><font color="#006F9A" ><b>E-mail (parent):</b></font>&nbsp;</div>
											<input name="email" id="email" size="20" type="text" onblur="checkEmail()" />
											<div id="emailMsg"><br /></div>
										</td>
									</tr>
									<tr>
										<td>
											<div align="left"><font color="#006F9A" ><b>UCC (student):</b></font>&nbsp;</div>
											<input name="egn" id="egn" size="20" type="text" onblur="getTeachers()" />
											<div id="message"><br /></div>
										</td>
									</tr>
									<tr>
										<td>
											<div align="left"><font color="#006F9A" ><b>Message:</b></font>&nbsp;</div>
												<textarea name="message" id="message" onblur="checkMessage()" cols="35" rows="3"></textarea>
											<div id="messageMsg"><br /></div>
										</td>
									</tr>
									<tr>
										<td align="center">
											<input type="submit" name="submit" value="Sent >" class="yellow_button" />
										</td>
									</tr> 
								</table>
							</form>
						</div>
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
				
				// излиза грешка ако са написани грешно username и password
				if($_SESSION!='loggedin')
				{
					main::getLoging();
				}
			?>
		</div>
	</div>
</body>
</html>