<?php
	session_start();
	error_reporting(0); 
	if($_SESSION['loggedin'] == false || ($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin' || $_SESSION['user_rank'] == 'teacher')))
	{
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('anketa_header.php');
		require_once('functions.php');
		
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
								Registration form for students
							</font>
							<br />
							<b>
								 All fields are required to be filled!
							</b>
						<hr width="80%" color="#c3c3c3" size="1" />
						<div id="message"></div>
						<form action="" method="post" name="register">
							<table width="auto" border="0" align="center">  
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
										<div align="center"><font color="#006F9A" ><b>E-mail:</b></font>&nbsp;</div>
										<input name="email" id="email" size="20" type="text" onblur="checkEmail()" />
										<div id="emailMsg"><br /></div>
									</td>
								</tr> 
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
										<div align="center"><font color="#006F9A" ><b>UCC:</b></font>&nbsp;</div>
										<input name="egn" id="egn" size="20" type="text" onblur="checkEgn()" />
										<div id="egnMsg"><br /></div>
									</td>
								</tr> 	
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Telephone:</b></font>&nbsp;</div>
										<input name="telefon" id="telefon" size="20" type="text" onblur="checkTelefon()" />
										<div id="telefonMsg"><br /></div>
									</td>
								</tr> 	
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Adress:</b></font>&nbsp;</div>
											<textarea name="mestojiveene" id="mestojiveene" onblur="checkMestojiveene()" cols="35" rows="3"></textarea>
										<div id="mestoMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td align="center">
										<div align="center"><font color="#006F9A" ><b>Class:</b></font>&nbsp;</div>
										<?php
												$oMain = new main;
												$teacherid = $oMain->get_teacherid($_SESSION['username']);
											
											echo '<select name="classid" id="classid" onblur="checkKlas()">
													<option value="----------">----------</option>';
													
														$oKlas = new klas;
														$oKlas->teacherid = $teacherid;
														$oKlas->teacherClasses();	
														
											echo '</select>';
										?>
										<div id="klasMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td align="center">
										<div align="center"><font color="#006F9A" ><b>Number in class:</b></font>&nbsp;</div>
										<input name="number" id="number" type="text" style="width:30px;" onblur="checkNumber()" />
										<div id="numberMsg"><br /></div>
									</td>
								</tr>  								
							</table>
							
						</form>
							<div align="center">
								<a href="#message"><input type="submit" name="submit" value="Register >" onclick="javascript:register_student()" class="yellow_button" /></a>
							</div>
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
				
				if($_SESSION!='loggedin')
				{
					main::getLoging();
				}
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