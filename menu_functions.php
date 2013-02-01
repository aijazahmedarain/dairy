<?php
	session_start();
	error_reporting(0);
	if($_SESSION['loggedin'] || $_SESSION['loggedin_student'])
	{
		require_once('connection/connector.php');
		require_once('config.php');
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
	<script type="text/javascript" src="js/boxover.js"></script>
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
						<?php
							$oSrok = new srok;
							
							echo '<div id="menu_functions">';
													
							if($_SESSION['user_rank'] == 'teacher' || $_SESSION['user_rank'] == 'director')
							{
									if($_SESSION['user_rank'] == 'director')
									{
										echo '<h1 align="left"><img src="images/dnevnik.gif" border="0" alt="" align="top" /> Options connected with the diary </h1>';
										
										include('scripts/menu/menu_director.php');
										include('scripts/menu/menu_admin.php');
									}
									
									echo '<div align="center"><h1 align="left"> <img src="images/class_f.png" alt="" align="top" /> Your classes : </h1>';
									$oMain = new main;
									$teacherid = $oMain->get_teacherid($_SESSION['username']);
									$select = $connect->query("SELECT * FROM ".$TABLES['teacher_klas']." where teacherid = '$teacherid' order by id ASC");
									echo '<div align="left">';
										if($connect->numRows($select))
										{
											while($row = $connect->fetchObject($select))
											{
												$classid = $row->classid;
												$select1 = $connect->query("SELECT * FROM ".$TABLES['paralelki']." where classid = '$classid'");
												while($row1 = $connect->fetchObject($select1))
												{
													echo ' <a href="list_students.php?classid='.$classid.'&method=functions" title="header=[<font style=\'font-size:12px\' >See list</font>] body=[<font style=\'font-size:12px\' >See the list with the students in this class. </font>]">'.$row1->klas.''.$row1->class_name.'</a> ';
												}
											}
										}
										else {
											echo '<div align="center"><div id="error">There are no registered classes for the moment!</div></div>';
										}
										echo '</div>';
									echo '</div>';
									$oSrok->check();
									
									$select_k = $connect->query("SELECT classid FROM ".$TABLES['klasen']." WHERE teacherid = '".mysql_real_escape_string($teacherid)."'") or die(MYSQL_ERROR);
									if($connect->numRows($select_k))
									{
										$row_k = $connect->fetchObject($select_k);
										$classid = $row_k->classid;
										
										$oKlas = new klas;
										echo '<h1> <img src="images/notification.png" alt="" height="20" width="20" /> You are form-master of : <a href="list_students.php?classid='.$classid.'&method=functions">'.$oKlas->printKlas($classid).'</a> class!</h1>';
										
										echo '<a href="set_subjects.php?classid='.$classid.'" title="header=[<font style=\'font-size:12px\' >Schedule</font>] body=[<font style=\'font-size:12px\' >Set the schedule of your class. </font>]"> <img src="images/program.png" alt="" border="0" /> Schedule</a> <br />';
										
										echo '<a href="otsastviq.php?classid='.$classid.'" title="header=[<font style=\'font-size:12px\' >Absences</font>] body=[<font style=\'font-size:12px\' >See and excuse absences </font>]"> <img src="images/otsastvie.png" alt="" border="0" /> Absences</a> <br />';
										
										echo '<a href="zabelejki.php?classid='.$classid.'&page=1" title="header=[<font style=\'font-size:12px\' >Notices</font>] body=[<font style=\'font-size:12px\' >See your class notices. </font>]"> <img src="images/zabelejka.png" alt="" border="0" /> Notices</a> ';
									}
									if($_SESSION['user_rank'] == 'teacher')
									{
										
										$select_messages = $connect->query("SELECT id FROM ".$TABLES['teacher_messages']." WHERE teacherid = '$teacherid' && checked = 'false'")or die(MYSQL_ERROR);
										
										echo '<h1 align="left"><img src="images/messages_teacher.png" width="22" height="22" border="0" alt="" align="top" /> Messages from parents ('.$connect->numRows($select_messages).') - <a href="teacher_messages.php">check</a> </h1>';
									}
								echo '<h1 align="left"><img src="images/program.png" alt="" border="0" /> Schedule - <a href="view_program.php" >check your schedule</a> </h1>';
							}
							if($_SESSION['user_rank'] == 'admin')
							{
								include('scripts/menu/menu_admin.php');
								echo '<br />';
								$oSrok->check();
							}				
							echo '<div style="height:5px;"></div>';
							
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
