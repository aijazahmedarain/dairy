<?php
	session_start();
	if($_SESSION['loggedin'] && $_SESSION['user_rank'] == 'teacher')
	{
		require_once('connection/connector.php');
		require_once('config.php');
		
		$connect = new DbConnector();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 School diary All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript">
		function delete_message(thing)
		{
			if(confirm("Are you sure you want to delete this message?"))
			{
				delete_thing(thing, 'delete_teacher_message.php');
				return true;
			}
			else {
				return false;
			}
		}
	</script>
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
						<table align="center" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" width="22%" class="list_td">
									Parent
								</td>
								<td align="center" width="8%" class="list_td">
									Class
								</td>
								<td align="center" width="23%" class="list_td">
									Name-student
								</td>
								<td align="center" width="42%" class="list_td">
									Message
								</td>
								<td align="center" width="5%" class="list_td">
									Del
								</td>
							</tr>
						</table>
						<table align="center" width="100%" cellpadding="0" cellspacing="0">
							<?php
								$oMain = new main;
								$teacherid = $oMain->get_teacherid($_SESSION['username']);
								
								$select = $connect->query("SELECT * FROM ".$TABLES['teacher_messages']." WHERE teacherid = '$teacherid'")or die(MYSQL_ERROR);
								
								if($connect->numRows($select))
								{
									$oKlas = new klas;
									$oStudents = new students;
									
									while($row = $connect->fetchObject($select))
									{
							?>
							<tr>
								<td height="5"></td>
							</tr>
							<tr id="<?php echo $row->id; ?>">
								<td align="center" width="22%">
									<?php
										$ime = $row->ime;
										
										if(strlen($ime) > 18)
										{
											$ime = substr($ime, 0, 15).'...';
										}
										if($row->checked == "false")
										{
											echo '<b>'.$ime.'</b>';
										}
										else {
											echo $ime;
										}
									?>
								</td>
								<td align="center" width="8%">
									<?php
										$select_classid = $connect->query("SELECT classid FROM ".$TABLES['uchenici']." WHERE egn = '".$row->egn."'")or die(MYSQL_ERROR);
										
										$row_classid = $connect->fetchObject($select_classid);
										
										if($row->checked == "false")
										{
											echo '<b>'.$oKlas->printKlas($row_classid->classid).'</b>';
										}
										else {
											echo $oKlas->printKlas($row_classid->classid);
										}
									?>
								</td>
								<td align="center" width="23%">
									<?php
										$ime_uchenik = $oStudents->printStudentsName($row->egn);
										
										if(strlen($ime_uchenik) > 18)
										{
											$ime_uchenik = substr($ime_uchenik, 0, 15).'...';
										}
										if($row->checked == "false")
										{
											echo '<b>'.$ime_uchenik.'</b>';
										}
										else {
											echo $ime_uchenik;
										}
									?>
								</td>
								<td align="center" width="42%">
								<a href="read_message.php?id=<?php echo $row->id; ?>" target="_blank">
									<?php
										// 55
										$message = $row->message;
										
										if(strlen($message) > 40)
										{
											$message = substr($message, 0, 37).'...';
										}
										if($row->checked == "false")
										{
											echo '<b>'.$message.'</b>';
										}
										else {
											echo $message;
										}
									?>
									</a>
								</td>
								<td align="center" width="5%">
									<a href="#" title="" >
										<img src="images/delete.gif" alt="" border="0" onclick="delete_message('<?php echo $row->id; ?>');" />
									</a>
								</td>
							</tr>
							<?php
									}
								}
								else 
								{
									echo '<div id="success">There are no messages!</div>';
								}
							?>
						</table>
						<div id="message"></div>
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