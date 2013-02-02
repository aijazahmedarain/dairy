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
						<hr width="90%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
							<?php
								$method = addslashes($_GET['method']);
								
								if($method == 'list') 
								{
									echo '<img src="images/icon_rangs.gif" alt="" /> List of the students';
								}
								else {
									echo '<img src="images/icon_rangs.gif" alt="" /> Add / Delete classes and sub-classes';
								}
							?>
							</font>
						<hr width="90%" color="#c3c3c3" size="1" />	
						<?php	
							$select = $connect->query("SELECT * FROM ".$TABLES['klasove']." order by id ASC") or die(MYSQL_ERROR);
							
							if($connect->numRows($select))
							{
								if($method == 'list') 
								{
									echo '<div align="left" style="margin-left:85px;">';
								}
								else 
								{
									echo '<div align="right" style="margin-right:85px;">';
								}
								
								while($row = $connect->fetchObject($select))
								{
									echo '<div><br /></div>
											<font color="green" >
												<b>'.$row->class.' Class</b> - ';
									if($method != 'list')
									{
											echo '<a href="create_par.php?class='.$row->class.'" title="header=[<font style=\'font-size:12px\' >Add sub-classes</font>] body=[<font style=\'font-size:12px\' >Gives you the opportunity to add sub-classes to the given class. </font>]">Add sub-classes</a> | 
												<a href="delete_par.php?class='.$row->class.'"  title="header=[<font style=\'font-size:12px\' >Delete sub-class</font>] body=[<font style=\'font-size:12px\' >Gives you the opportunity to delete sub-classes from the given class. </font>]">Delete sub-class</a> |'; 
									}
									
									if($method == 'list') 
									{
										$class = $row->class;
										$select2 = $connect->query("SELECT * FROM ".$TABLES['paralelki']." where klas = '".mysql_real_escape_string($class)."' order by id ASC ");
										if($connect->numRows($select2))
										{
											while($row2 = $connect->fetchObject($select2))
											{
												echo "<b>, ".'<a href="list_students.php?classid='.$row2->classid.'&method='.$method.'">'.$row2->class_name.'</a></b>';
											}
										}
										else {
											echo '<font color="red">There are no sub-classes in this class.</font>';
										}
									} 
										
									if($method != 'list')
									{
										echo ' <a href="#" title="header=[<font style=\'font-size:12px\' >Delete class</font>] body=[<font style=\'font-size:12px\' >Delete this class and all sub-classes given to it. </font>]" onclick="confirm_delete_class('.$row->class.')" >Delete</a>
											</font>';
									}
								}
								echo '<br /><br /><div align="center"><div id="message"></div></div>';
								echo '</div><div><br /></div><hr width="90%" color="#c3c3c3" size="1" />';
							}
							else 
							{
								$ot = addslashes($_POST['ot']);
								$do = addslashes($_POST['do']);
								
								$action = $_GET['action'];
								if($action!=2)
								{
								?>
								<br />
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2" method="post">
								<font color="#006F9A" ><b>From: </b></font><select name="ot">
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
									</select><br /><br />
								<font color="#006F9A" ><b>To: </b></font><select name="do">
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
									</select>
									<br /><br />
									<input type="submit" value="Create classes" class="yellow_button" />
								</form>
								<hr width="90%" color="#c3c3c3" size="1" />	
								<?php
								}
								if($action == 2)
								{	
									if(isset($ot) && isset($do) && is_numeric($ot) && is_numeric($do) && $do >= $ot)
									{
										echo '<div id="success">Successfully created classes, please wait!</div>';
										for($i=$ot;$i<=$do;$i++)
										{
											echo '<div><br /></div>
													<font color="#006F9A" >
														<b>'.$i.' Class</b>
													</font>';
													
											$query = $connect->query("INSERT INTO ".$TABLES['klasove']." (class) VALUES('$i')") or die(mysql_error);
											if($query) echo '<meta http-equiv="refresh" content="3;url=classes.php" />';
										}
									}
									else {
										echo '<div id="error">Incorrectly selected classes!</div>';
										echo '<meta http-equiv="refresh" content="2;url=classes.php" />';
									}
									echo '<hr width="90%" color="#c3c3c3" size="1" />';
								}
							}
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