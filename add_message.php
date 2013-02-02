<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		// require Connection, Functions and Variables
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('anketa_header.php');
		
		// ако искаме да направим някаква заявка към базата използваме тази променлива
		$connect = new DbConnector();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
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
					<td class="left_content" valign="top">
						<hr width="80%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
								<img src="images/message.gif" alt="" /> 
								Add new message
							</font>
							<br />
						<hr width="80%" color="#c3c3c3" size="1" />
						<div align="center">
							<div style="width:506px;">
								<?php
									if(isset($_POST["submit"])) 
									{
										if(!empty($_POST["name"])) 
										{
											$name = htmlspecialchars($_POST["name"]);
										}
										else {
											$errMsg = "Add name of the message!!!<br />";
										}
										if(!empty($_POST["news"])) 
										{	
											$news = $_POST["news"];
										}
										else { 
											$errMsg = "Add a message!!!<br />";
										}
										if(empty($errMsg))
										{
											$insert = $connect->query("INSERT INTO ".$TABLES['messages']." (news,name) VALUES ('$news', '$name')")or die(MYSQL_ERROR);
											echo '<div id="success"><b>Successfully added message!</b></div>';
										} 	
										else {
											echo '<div id="error">'.$errMsg.'</div>';
										}
									}
										
									echo '<form action="" method="post">
										 <font color="#006F9A" ><b>Title : </b></font><input type=text size="50" name="name" />
										 <br / ><br />
										 <div style="border : 2px ridge #2457ca;">';
								?>
								<textarea id="textarea1" name="news"><b>Added by : </b><u><?php echo $_SESSION['username']; ?></u></textarea>
								<script language="JavaScript">
								  generate_wysiwyg('textarea1');
								</script> 
								<?php
									echo '</div><br /><input type="submit" name="submit" value="Save" class="yellow_button" /></form>';
								?>
							</div>
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