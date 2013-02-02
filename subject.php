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
	<script type="text/javascript" src="js/ajax.js"></script>
</head>
<body onload="load_all_subjects()">
	<script type="text/javascript" src="js/register_check.js"></script>
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
								<img src="images/predmet_1.png" alt="" /> 
								Add / delete subject
							</font>
						<hr width="80%" color="#c3c3c3" size="1" />
							<table width="100%" border="0" align="center">  
								<tr>
									<td width="100%">
										<div align="center"><font color="#006F9A" ><b>Subject - adding:</b> </font>&nbsp;</div>
										<input name="predmet" id="predmet" size="30" type="text" />
										<div style="height:5px"></div><div id="message"><br /></div><div style="height:5px"></div>
									</td>
								</tr>	
								<tr>
									<td align="center">
										<input type="submit" name="submit" value="Add >" onclick="add_subject()" class="yellow_button" />
									</td>
								</tr> 
							</table>
						<hr width="80%" color="#c3c3c3" size="1" />
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2" method="post">
							<table width="auto" border="0" align="center">  
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Subject - deleting:</b> </font>&nbsp;</div><br />
										<?php
												$predmet = $_POST['predmet'];
												$select = $connect->query("SELECT * FROM ".$TABLES['predmeti']."") or die(MYSQL_ERROR);
												$count = $connect->numRows($select);
												$action = $_GET['action'];
												
												if($action == 2)
												{
													if(isset($predmet)) 
													{
														for($i = 0; $i<$count; $i++)
														{
															$predmeti = $predmet[$i];
															$delete = $connect->query("DELETE FROM ".$TABLES['predmeti']." where predmetid = '$predmeti'") or die(MYSQL_ERROR);
															$delete2 = $connect->query("DELETE FROM ".$TABLES['predmet_teacher']." where predmetid = '$predmeti'") or die(MYSQL_ERROR);
															$delete3 = $connect->query("DELETE FROM ".$TABLES['predmet_klas']." where predmetid = '$predmeti'") or die(MYSQL_ERROR);
															$delete4 = $connect->query("DELETE FROM ".$TABLES['ocenki']." where predmetid = '$predmeti'") or die(MYSQL_ERROR);
															$delete5 = $connect->query("DELETE FROM ".$TABLES['godishni']." where predmetid = '$predmeti'") or die(MYSQL_ERROR);
															$delete6 = $connect->query("DELETE FROM ".$TABLES['srochni']." where predmetid = '$predmeti'") or die(MYSQL_ERROR);
														}
														if($delete) {
															echo '<meta http-equiv="refresh" content="0;url=subject.php" />';
														}
													}
												}
												echo '<div id="message2"></div>';
											?>
										<div><br /></div>
									</td>
								</tr>	
								<tr>
									<td align="center">
										<input type="submit" name="submit_delete" value="Delete >" class="yellow_button" />
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