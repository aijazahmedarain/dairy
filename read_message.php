<?php
	session_start();
	if($_SESSION['loggedin'] && $_SESSION['user_rank'] == 'teacher')
	{
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('anketa_header.php');
		
		$connect = new DbConnector();
		
		$oMain = new main;
		$teacherid = $oMain->get_teacherid($_SESSION['username']);
		$id = htmlspecialchars($_GET['id']);
		
		$check = $connect->query("SELECT id FROM ".$TABLES['teacher_messages']." WHERE teacherid = '$teacherid' && id = '$id'")or die(MYSQL_ERROR);
		
		if($connect->numRows($check))
		{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
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
								<img src="images/messages_teacher.png" alt="" /> 
								Messages sent from parents
							</font>
						<hr width="80%" color="#c3c3c3" size="1" />
						<?php
							$select = $connect->query("SELECT * FROM ".$TABLES['teacher_messages']." WHERE id = '$id'")or die(MYSQL_ERROR);
							
							$row = $connect->fetchObject($select);
						?><div><br /></div>
						<table align="center" width="86%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left">
									<font color="#006F9A" ><b>Name of the parent :</b></font> 
									<u><?php 
										echo $row->ime;
									?></u> 
								</td>
							</tr>
							<tr>
								<td height="10"></td>
							</tr>
							<tr>
								<td align="left">
									<font color="#006F9A" ><b>Name of the student :</b></font>
									<u><?php
										$oStudents = new students;
										
										echo $ime_uchenik = $oStudents->printStudentsName($row->egn);
									?></u>
								</td>
							</tr>
							<tr>
								<td height="10"></td>
							</tr>
							<tr>
								<td align="left">
									<font color="#006F9A" ><b>Class :</b></font>
									<u><?php
										$oKlas = new klas;
										
										$select_classid = $connect->query("SELECT classid FROM ".$TABLES['uchenici']." WHERE egn = '".$row->egn."'")or die(MYSQL_ERROR);
										
										$row_classid = $connect->fetchObject($select_classid);
										
										echo $oKlas->printKlas($row_classid->classid);
									?></u>
								</td>
							</tr>
							<tr>
								<td height="10"></td>
							</tr>
							<tr>
								<td align="left">
									<font color="#006F9A" ><b>Date :</b></font>
									<u><?php
										echo $row->date;
									?></u>
								</td>
							</tr>
							<tr>
								<td height="10"></td>
							</tr>
							<tr>
								<td align="left">
									<font color="#006F9A" ><b>Message :</b></font>
									<?php
										echo $row->message;
									?>
								</td>
							</tr>
						</table>
						<br />
						<font color="green" size="3" ><b>Response :</b></font>
						<hr width="80%" color="#c3c3c3" size="1" />
						<?php
							if(isset($_POST['submit']))
							{
								$message = htmlspecialchars($_POST['message']);
								
								$to = $row->email;
								
								$subject = "E-dnevnik";
								
								$headers = $headers = 'From: e-dnevnik@gmail.com' . "\r\n" .
										'Reply-To: e-dnevnik@gmail.com' . "\r\n" .
										'X-Mailer: PHP/' . phpversion();
								
								$query = $connect->query("UPDATE ".$TABLES['teacher_messages']." SET checked = 'true' WHERE id = '$id'")or die(MYSQL_ERROR);
								
								if(mail($to, $subject, $message, $headers) && $query)
								{
									echo '<div id="success">Successfully sent message!</div>';
								}
							}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>" method="post">
							<textarea name="message" cols="40" rows="4">
							</textarea>
							<div style="height:5px;"></div>
							<div align="center">
								<input type="submit" name="submit" value="Send >" class="yellow_button" />
							</div>
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
			header('Location: teacher_messages.php');
		}
	}
	else {
		header('Location: index.php');
	}
?>