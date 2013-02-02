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
								Manage classes - <font color="green"><u>Deleting</u></font>
							</font>
						<hr width="80%" color="#c3c3c3" size="1" />	
						<?php
							$class = addslashes($_GET['class']);
							$par = $_POST['par'];
							
							echo '<font color="#006F9A" ><b>Deleting sub-classes : </b></font><div><br /></div>';
							
							$select2 = $connect->query("SELECT * FROM ".$TABLES['paralelki']." where klas = '$class' order by id ASC") or die(MYSQL_ERROR);
							$count = $connect->numRows($select2);
							
							if(isset($par) && isset($class))
							{
								for($i = 0; $i < $count; $i++)
								{
									$del = $par[$i];
									if($del != 0)
									{
										$delete = $connect->query("DELETE FROM ".$TABLES['paralelki']." where classid = '$del'") or die(MYSQL_ERROR);
										$delete2 = $connect->query("DELETE FROM ".$TABLES['uchenici']." where classid = '$del'") or die(MYSQL_ERROR);
										$delete3 = $connect->query("DELETE FROM ".$TABLES['teacher_klas']." where classid = '$del'")or die(MYSQL_ERROR);
										$delete4 = $connect->query("DELETE FROM ".$TABLES['predmet_klas']." where classid = '$del'")or die(MYSQL_ERROR);
										$delete5 = $connect->query("DELETE FROM ".$TABLES['ocenki']." where classid = '$del'")or die(MYSQL_ERROR);
										$delete6 = $connect->query("DELETE FROM ".$TABLES['godishni']." where classid = '$del'")or die(MYSQL_ERROR);
										$delete7 = $connect->query("DELETE FROM ".$TABLES['srochni']." where classid = '$del'")or die(MYSQL_ERROR);
										$delete8 = $connect->query("DELETE FROM ".$TABLES['otsastviq']." where classid = '$del'")or die(MYSQL_ERROR);
										$delete9 = $connect->query("DELETE FROM ".$TABLES['users']." where classid = '$del'")or die(MYSQL_ERROR);
									}
								}
								if($delete) {
									echo '<meta http-equiv="refresh" content="0;url=delete_par.php?class='.$class.'" />';
								}
							}
							else if(isset($_POST['submit'])) 
							{
								echo '<div align="center"><div id="error">Select the sub-classes you want to delete!</div></div><br />';	
							}
							echo '<form action="'.$_SERVER['PHP_SELF'].'?class='.$class.'" method="post">';
							
								if($connect->numRows($select2)) 
								{
									while($row = $connect->fetchObject($select2)) 
									{
										echo '<input type="checkbox" name="par[]" value="'.$row->classid.'"> '.$row->class_name.' ';
									}
									echo '<div><br /></div><input type="submit" name="submit" class="yellow_button" value="Delete" onclick="return erase(\' this sub-classes \')" />';
								}
								else echo '<b>There are still no sub-classes in this class.</b><div><br /></div>
											<b><a href="create_par.php?class='.$class.'">> Add sub-classes <</a></b>';		
								
							echo '</form>';
							echo '<hr width="80%" color="#c3c3c3" size="1" />';
							echo '<div><br /></div>
								<a href="classes.php"><b>. : Go back : .</b></a>';
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