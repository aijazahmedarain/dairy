<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('functions.php');
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
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript">
		function delete_message(thing)
		{
			if(confirm("Are you sure you want to delete this message?"))
			{
				delete_thing(thing, 'delete_message.php');
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
						<h1 align="left"><img src="images/message.gif" alt="" /> Messages</h1>	
						<table align="center" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" width="90%" class="list_td">
									Topic of the message
								</td>
								<td align="center" width="5%" class="list_td">
									Edit
								</td>
								<td align="center" width="5%" class="list_td">
									Del
								</td>
							</tr>
						</table>
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<?php
									$select = $connect->query("SELECT * FROM ".$TABLES['messages']." order by id desc")or die(mysql_error());
									if ($connect->numRows($select))
									{
										while($red = $connect->fetchObject($select))
										{
								?>
											<tr id="<?php echo $red->id; ?>">
												<td width="90%" class="list_td_info">
													<?php echo $red->name;?>
												</td>
												<td width="5%" valign="top" class="list_td_info" >
													<a href="edit_message.php?tid=<?php echo $red->id; ?>" title="Edit this message">
														<img src="images/edit.gif" alt="" border="0" />
													</a>
												</td>
												<td width="5%" valign="top" class="list_td_info">
													<a href="#" title="Delete this message" onclick="delete_message('<?php echo $red->id; ?>');">
														<img src="images/delete.gif" alt="" border="0" />
													</a>
												</td>
											</tr>
								<?php
										}
									}
									else {
										echo '<div><br /></div><b>No messages</b><div><br /></div>';
									}
								?>
							</table>
						<br />
						<div id="message"></div>
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