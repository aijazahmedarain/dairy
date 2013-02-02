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
<!-- Copyright 2013 School diary All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script type="text/javascript" src="js/register_check.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
</head>
<body onload="load_subjects()">
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
								Subjects for the classes
							</font>
						<hr width="80%" color="#c3c3c3" size="1" />
						<?php
							$classid = addslashes($_POST['classid']);
							
							$predmet = $_POST['predmet'];
							
							$action = $_GET['action'];
							
							if($classid == '----------')
							{
								$action = 1;
								echo '<div align="center"><div id="error">Please, select a class!</div></div>';
							}
							else {
								if($action == 2 && $action != 1)
								{
									if(isset($predmet) && isset($classid) && is_numeric($classid))
									{
										$select = $connect->query("SELECT * FROM ".$TABLES['predmeti']."") or die(MYSQL_ERROR);
										$count1 = $connect->numRows($select);
										
										$delete = $connect->query("DELETE FROM ".$TABLES['predmet_klas']." where classid = '".mysql_real_escape_string($classid)."'") or die(MYSQL_ERROR);
										
										$oKlas = new klas;
										
										for($i=0;$i<=$count1;$i++)
										{
											$predmeti = $predmet[$i];
											if($predmeti!=0)
											{
												$query = $connect->query("INSERT INTO ".$TABLES['predmet_klas']." (classid, predmetid) VALUES('$classid', '$predmeti')")or die(MYSQL_ERROR);
											}
										}
										if($query)
										{
											echo '<div align="center"><div id="success">Successfully set subjects to '.$oKlas->printKlas($classid).' class!</div></div>';
										}
									}
								}
							}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2" method="post" name="register">
							<table width="auto" border="0" align="center">  
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Class:</b></font>&nbsp;</div>
										<?php
											$select = $connect->query("SELECT * FROM ".$TABLES['paralelki']." order by klas desc") or die(MYSQL_ERROR);
											if($connect->numRows($select)) 
											{
												echo '<select name="classid" id="classid" onblur="checkKlas()" onchange="load_subjects()">';
												
													if($action == 2)
													{
														
														
														echo '<option value="'.$classid.'">'.$oKlas->printKlas($classid).'</option>';
													}
													echo '<option value="----------">----------</option>';
														
												while($row = $connect->fetchObject($select))
												{
													echo '<option value='.$row->classid.'>'.$row->klas.''.$row->class_name.' class</option>';
												}
												echo '</select>';
											}
											else {
												echo '<div align="center"><div id="error">There are still no added classes!</div></div>';
											}
										?>
										<div id="klasMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Subjects:</b></font>&nbsp;</div>
										<div align="left" style="margin-left:0px;">
											<div id="subjects">
												<div><br /></div>
												<b>Please, choose a subject!</b>
												<div><br /></div>
											</div>
										</div>
									</td>
								</tr> 						
								<tr>
									<td align="center">
										<input type="submit" name="submit" value="Add >" class="yellow_button" />
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