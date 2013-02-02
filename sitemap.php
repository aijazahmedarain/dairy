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
	<script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script> 
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
						<hr width="80%" color="#c3c3c3" size="1" />
						<font color="#006F9A" size="5">
							<img src="images/sitemap.png" alt="" /> 
							Map of the site
						</font>
						<br />
						<hr width="80%" color="#c3c3c3" size="1" />	
						<table cellpadding="0" cellspacing="0" border="0" width="45%" id="sitemap" align="center">
						<tr>
							<td height="20"></td>
						</tr>
						<tr><td align="left"><a href="index.php" title="
								Home page of the diary
									">
								<img src="images/arrow.png" alt="" border="0" /> Home page
									</a></td></tr>
						<tr>
							<td height="20"></td>
						</tr>
						<tr><td align="left"><a href="contacts.php" title="
								Cantacts with the teaching staff
									">
								<img src="images/arrow.png" alt="" border="0" /> Contacts
									</a></td></tr>
						<tr>
							<td height="20"></td>
						</tr>
						<tr><td align="left"><a href="register_student.php" title="
								Регистрация предназначена за ученици
									">
								<img src="images/arrow.png" alt="" border="0" /> Registration Student
									</a></td></tr>
						<tr>
							<td height="20"></td>
						</tr>
						</table>
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